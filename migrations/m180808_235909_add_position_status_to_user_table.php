<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m180808_235909_add_position_status_to_user_table
 */
class m180808_235909_add_position_status_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'status', Schema::TYPE_SMALLINT.' NOT NULL');
        $this->addColumn('user', 'updated_at', Schema::TYPE_INTEGER.' NOT NULL');
        $this->addColumn('user', 'created_at', Schema::TYPE_INTEGER.' NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180808_235909_add_position_status_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
