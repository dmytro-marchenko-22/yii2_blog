<?php

namespace tests\unit\models;

use app\models\Comment;
use Codeception\Test\Unit;
use UnitTester;

class CommentTest_Simple extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function testValidate()
    {
        $comment = new Comment();
        $this->assertFalse($comment->validate());

        $comment->post_id = 1;
        $comment->name = 'Test User';
        $comment->email = 'test@example.com';
        $comment->content = 'Test comment';
        
        $this->assertTrue($comment->validate());
    }

    public function testPostIdRequired()
    {
        $comment = new Comment();
        $comment->name = 'Test User';
        $comment->email = 'test@example.com';
        $comment->content = 'Test comment';
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('post_id', $comment->errors);
    }

    public function testNameRequired()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->email = 'test@example.com';
        $comment->content = 'Test comment';
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('name', $comment->errors);
    }

    public function testEmailRequired()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->name = 'Test User';
        $comment->content = 'Test comment';
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('email', $comment->errors);
    }

    public function testContentRequired()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->name = 'Test User';
        $comment->email = 'test@example.com';
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('content', $comment->errors);
    }

    public function testEmailFormat()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->name = 'Test User';
        $comment->email = 'invalid-email';
        $comment->content = 'Test comment';
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('email', $comment->errors);
    }

    public function testNameMaxLength()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->name = str_repeat('a', 256);
        $comment->email = 'test@example.com';
        $comment->content = 'Test comment';
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('name', $comment->errors);
    }

    public function testEmailMaxLength()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->name = 'Test User';
        $comment->email = str_repeat('a', 250) . '@example.com';
        $comment->content = 'Test comment';
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('email', $comment->errors);
    }

    public function testStatus()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->name = 'Test User';
        $comment->email = 'test@example.com';
        $comment->content = 'Test comment';
        $comment->status = Comment::STATUS_ACTIVE;
        
        $this->assertTrue($comment->validate());
        $this->assertEquals($comment->status, Comment::STATUS_ACTIVE);
    }

    public function testStatusConstants()
    {
        $this->assertEquals(Comment::STATUS_INACTIVE, 0);
        $this->assertEquals(Comment::STATUS_ACTIVE, 1);
    }

    public function testInvalidStatus()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->name = 'Test User';
        $comment->email = 'test@example.com';
        $comment->content = 'Test comment';
        $comment->status = 99;
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('status', $comment->errors);
    }

    public function testParentId()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->parent_id = 5;
        $comment->name = 'Test User';
        $comment->email = 'test@example.com';
        $comment->content = 'Test reply';
        
        $this->assertTrue($comment->validate());
        $this->assertEquals($comment->parent_id, 5);
    }

    public function testAttributeLabels()
    {
        $comment = new Comment();
        $labels = $comment->attributeLabels();
        
        $this->assertArrayHasKey('name', $labels);
        $this->assertArrayHasKey('email', $labels);
        $this->assertArrayHasKey('content', $labels);
        $this->assertArrayHasKey('post_id', $labels);
    }

    public function testTableName()
    {
        $this->assertEquals(Comment::tableName(), '{{%comment}}');
    }

    public function testBehaviors()
    {
        $comment = new Comment();
        $behaviors = $comment->behaviors();
        
        $this->assertNotEmpty($behaviors);
    }
}
