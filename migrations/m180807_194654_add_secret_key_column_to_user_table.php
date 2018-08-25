<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles adding secret_key to table `user`.
 */
class m180807_194654_add_secret_key_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'secret_key', Schema::TYPE_STRING);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'secret_key');
    }
}
