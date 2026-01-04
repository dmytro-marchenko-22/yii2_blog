<?php

namespace tests\unit;

use app\models\Comment;
use PHPUnit\Framework\TestCase;

class SimpleCommentTest extends TestCase
{
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

    public function testEmailRequired()
    {
        $comment = new Comment();
        $comment->post_id = 1;
        $comment->name = 'Test User';
        $comment->content = 'Test comment';
        
        $this->assertFalse($comment->validate());
        $this->assertArrayHasKey('email', $comment->errors);
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

    public function testStatusConstants()
    {
        $this->assertEquals(Comment::STATUS_INACTIVE, 0);
        $this->assertEquals(Comment::STATUS_ACTIVE, 1);
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
