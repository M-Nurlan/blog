<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180802_140640_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'gender' => $this->string()->notNull(),
            'location' => $this->string(),
            'birthday' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
