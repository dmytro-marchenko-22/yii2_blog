<?php

namespace tests\unit;

use app\models\Post;
use app\models\Category;
use PHPUnit\Framework\TestCase;

class SimplePostTest extends TestCase
{
    public function testValidate()
    {
        $post = new Post();
        $this->assertFalse($post->validate());

        $post->title = 'Test Post';
        $post->content = 'Test content';
        $post->category_id = 1;
        
        $this->assertTrue($post->validate());
    }

    public function testTitleRequired()
    {
        $post = new Post();
        $post->content = 'Test content';
        $post->category_id = 1;
        
        $this->assertFalse($post->validate());
        $this->assertArrayHasKey('title', $post->errors);
    }

    public function testContentRequired()
    {
        $post = new Post();
        $post->title = 'Test Post';
        $post->category_id = 1;
        
        $this->assertFalse($post->validate());
        $this->assertArrayHasKey('content', $post->errors);
    }

    public function testCategoryIdRequired()
    {
        $post = new Post();
        $post->title = 'Test Post';
        $post->content = 'Test content';
        
        $this->assertFalse($post->validate());
        $this->assertArrayHasKey('category_id', $post->errors);
    }

    public function testStatusConstants()
    {
        $this->assertEquals(Post::STATUS_DRAFT, 0);
        $this->assertEquals(Post::STATUS_PUBLISHED, 1);
    }

    public function testTableName()
    {
        $this->assertEquals(Post::tableName(), '{{%post}}');
    }

    public function testBehaviors()
    {
        $post = new Post();
        $behaviors = $post->behaviors();
        
        $this->assertNotEmpty($behaviors);
    }
}
