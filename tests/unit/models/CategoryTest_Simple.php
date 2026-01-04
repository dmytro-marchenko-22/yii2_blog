<?php

namespace tests\unit\models;

use app\models\Category;
use Codeception\Test\Unit;
use UnitTester;

class CategoryTest_Simple extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function testValidate()
    {
        $category = new Category();
        $this->assertFalse($category->validate());

        $category->name = 'Test Category';
        
        $this->assertTrue($category->validate());
    }

    public function testNameRequired()
    {
        $category = new Category();
        
        $this->assertFalse($category->validate());
        $this->assertArrayHasKey('name', $category->errors);
    }

    public function testNameMaxLength()
    {
        $category = new Category();
        $category->name = str_repeat('a', 256);
        
        $this->assertFalse($category->validate());
        $this->assertArrayHasKey('name', $category->errors);
    }

    public function testSlug()
    {
        $category = new Category();
        $category->name = 'Test Category';
        $category->slug = 'test-category';
        
        $this->assertTrue($category->validate());
        $this->assertEquals($category->slug, 'test-category');
    }

    public function testSlugMaxLength()
    {
        $category = new Category();
        $category->name = 'Test Category';
        $category->slug = str_repeat('a', 256);
        
        $this->assertFalse($category->validate());
        $this->assertArrayHasKey('slug', $category->errors);
    }

    public function testDescription()
    {
        $category = new Category();
        $category->name = 'Test Category';
        $category->description = 'This is a test category description';
        
        $this->assertTrue($category->validate());
        $this->assertEquals($category->description, 'This is a test category description');
    }

    public function testAttributeLabels()
    {
        $category = new Category();
        $labels = $category->attributeLabels();
        
        $this->assertArrayHasKey('name', $labels);
        $this->assertArrayHasKey('slug', $labels);
        $this->assertArrayHasKey('description', $labels);
    }

    public function testTableName()
    {
        $this->assertEquals(Category::tableName(), '{{%category}}');
    }

    public function testBehaviors()
    {
        $category = new Category();
        $behaviors = $category->behaviors();
        
        $this->assertNotEmpty($behaviors);
    }
}
