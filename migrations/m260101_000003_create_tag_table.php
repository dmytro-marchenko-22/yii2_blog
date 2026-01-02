<?php

use yii\db\Migration;

class m260101_000003_create_tag_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'slug' => $this->string(255)->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-tag-slug', '{{%tag}}', 'slug');
    }

    public function safeDown()
    {
        $this->dropIndex('idx-tag-slug', '{{%tag}}');
        $this->dropTable('{{%tag}}');
    }
}
