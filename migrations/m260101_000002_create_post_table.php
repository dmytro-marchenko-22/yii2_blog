<?php

use yii\db\Migration;

class m260101_000002_create_post_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'category_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'image' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);

        $this->createIndex('idx-post-category_id', '{{%post}}', 'category_id');
        $this->createIndex('idx-post-author_id', '{{%post}}', 'author_id');
        $this->createIndex('idx-post-slug', '{{%post}}', 'slug');
        $this->createIndex('idx-post-status', '{{%post}}', 'status');
        $this->createIndex('idx-post-created_at', '{{%post}}', 'created_at');

        $this->addForeignKey('fk-post-category_id', '{{%post}}', 'category_id', '{{%category}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-post-author_id', '{{%post}}', 'author_id', '{{%user}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-post-author_id', '{{%post}}');
        $this->dropForeignKey('fk-post-category_id', '{{%post}}');
        $this->dropIndex('idx-post-created_at', '{{%post}}');
        $this->dropIndex('idx-post-status', '{{%post}}');
        $this->dropIndex('idx-post-slug', '{{%post}}');
        $this->dropIndex('idx-post-author_id', '{{%post}}');
        $this->dropIndex('idx-post-category_id', '{{%post}}');
        $this->dropTable('{{%post}}');
    }
}
