<?php

use yii\db\Migration;

class m260101_000001_create_category_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'slug' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-category-slug', '{{%category}}', 'slug');
    }

    public function safeDown()
    {
        $this->dropIndex('idx-category-slug', '{{%category}}');
        $this->dropTable('{{%category}}');
    }
}
