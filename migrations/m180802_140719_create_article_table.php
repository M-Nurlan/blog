<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m180802_140719_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article', [
            'article_id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article');
    }
}
