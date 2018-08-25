<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles adding created_at to table `user`.
 */
class m180809_210022_add_created_at_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'updated_at', Schema::TYPE_INTEGER.' NOT NULL');
        $this->addColumn('user', 'created_at', Schema::TYPE_INTEGER.' NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
