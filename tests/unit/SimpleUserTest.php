<?php

namespace tests\unit\models;

use app\models\User;
use PHPUnit\Framework\TestCase;

class SimpleUserTest extends TestCase
{
    public function testValidate()
    {
        $user = new User();
        $this->assertFalse($user->validate());

        $user->username = 'admin';
        $user->email = 'admin@example.com';
        
        $this->assertTrue($user->validate());
    }

    public function testUsernameRequired()
    {
        $user = new User();
        $user->email = 'test@example.com';
        
        $this->assertFalse($user->validate());
        $this->assertArrayHasKey('username', $user->errors);
    }

    public function testEmailRequired()
    {
        $user = new User();
        $user->username = 'testuser';
        
        $this->assertFalse($user->validate());
        $this->assertArrayHasKey('email', $user->errors);
    }

    public function testEmailFormat()
    {
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'invalid-email';
        
        $this->assertFalse($user->validate());
        $this->assertArrayHasKey('email', $user->errors);
    }

    public function testUsernameMinLength()
    {
        $user = new User();
        $user->username = 'a';
        $user->email = 'test@example.com';
        
        $this->assertFalse($user->validate());
        $this->assertArrayHasKey('username', $user->errors);
    }

    public function testAttributeLabels()
    {
        $user = new User();
        $labels = $user->attributeLabels();
        
        $this->assertArrayHasKey('username', $labels);
        $this->assertArrayHasKey('email', $labels);
        $this->assertArrayHasKey('id', $labels);
    }

    public function testTableName()
    {
        $this->assertEquals(User::tableName(), '{{%user}}');
    }

    public function testStatusConstants()
    {
        $this->assertEquals(User::STATUS_INACTIVE, 0);
        $this->assertEquals(User::STATUS_ACTIVE, 10);
    }

    public function testBehaviors()
    {
        $user = new User();
        $behaviors = $user->behaviors();
        
        $this->assertNotEmpty($behaviors);
    }
}
