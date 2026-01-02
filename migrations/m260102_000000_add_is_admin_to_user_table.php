<?php

use yii\db\Migration;

class m260102_000000_add_is_admin_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'is_admin', $this->boolean()->defaultValue(false)->after('status'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'is_admin');
    }
}
