<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m180802_140659_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'comment_id' => $this->primaryKey(),
            'comment' => $this->text()->notNull(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');
    }
}
