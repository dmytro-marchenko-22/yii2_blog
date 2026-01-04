<?php

namespace tests\unit\models;

use app\models\Post;
use app\models\Category;
use Codeception\Test\Unit;
use UnitTester;

class PostTest_Simple extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

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

    public function testTitleMaxLength()
    {
        $post = new Post();
        $post->title = str_repeat('a', 256);
        $post->content = 'Test content';
        $post->category_id = 1;
        
        $this->assertFalse($post->validate());
        $this->assertArrayHasKey('title', $post->errors);
    }

    public function testStatus()
    {
        $post = new Post();
        $post->title = 'Test Post';
        $post->content = 'Test content';
        $post->category_id = 1;
        $post->status = Post::STATUS_PUBLISHED;
        
        $this->assertTrue($post->validate());
        $this->assertEquals($post->status, Post::STATUS_PUBLISHED);
    }

    public function testStatusConstants()
    {
        $this->assertEquals(Post::STATUS_DRAFT, 0);
        $this->assertEquals(Post::STATUS_PUBLISHED, 1);
    }

    public function testInvalidStatus()
    {
        $post = new Post();
        $post->title = 'Test Post';
        $post->content = 'Test content';
        $post->category_id = 1;
        $post->status = 99;
        
        $this->assertFalse($post->validate());
        $this->assertArrayHasKey('status', $post->errors);
    }

    public function testAttributeLabels()
    {
        $post = new Post();
        $labels = $post->attributeLabels();
        
        $this->assertArrayHasKey('title', $labels);
        $this->assertArrayHasKey('content', $labels);
        $this->assertArrayHasKey('category_id', $labels);
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
