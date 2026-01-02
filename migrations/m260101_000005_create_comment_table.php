<?php

use yii\db\Migration;

class m260101_000005_create_comment_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'user_id' => $this->integer(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);

        $this->createIndex('idx-comment-post_id', '{{%comment}}', 'post_id');
        $this->createIndex('idx-comment-parent_id', '{{%comment}}', 'parent_id');
        $this->createIndex('idx-comment-user_id', '{{%comment}}', 'user_id');
        $this->createIndex('idx-comment-status', '{{%comment}}', 'status');
        $this->createIndex('idx-comment-created_at', '{{%comment}}', 'created_at');

        $this->addForeignKey('fk-comment-post_id', '{{%comment}}', 'post_id', '{{%post}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-comment-parent_id', '{{%comment}}', 'parent_id', '{{%comment}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-comment-user_id', '{{%comment}}', 'user_id', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-comment-user_id', '{{%comment}}');
        $this->dropForeignKey('fk-comment-parent_id', '{{%comment}}');
        $this->dropForeignKey('fk-comment-post_id', '{{%comment}}');
        $this->dropIndex('idx-comment-created_at', '{{%comment}}');
        $this->dropIndex('idx-comment-status', '{{%comment}}');
        $this->dropIndex('idx-comment-user_id', '{{%comment}}');
        $this->dropIndex('idx-comment-parent_id', '{{%comment}}');
        $this->dropIndex('idx-comment-post_id', '{{%comment}}');
        $this->dropTable('{{%comment}}');
    }
}
