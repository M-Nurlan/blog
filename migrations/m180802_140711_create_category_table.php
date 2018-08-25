<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180802_140711_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'category_id' => $this->primaryKey(),
            'category_name' => $this->string(),
            'category_intro' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
