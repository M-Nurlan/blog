<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles adding user_name to table `article`.
 */
class m180811_132935_add_user_name_column_to_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('article', 'user_name', Schema::TYPE_STRING.' NOT NULL');
        $this->addColumn('article', 'updated_at', Schema::TYPE_SMALLINT.' NOT NULL');
        $this->addColumn('article', 'created_at', Schema::TYPE_SMALLINT.' NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('article', 'user_name');
        $this->addColumn('article', 'updated_at');
        $this->addColumn('article', 'created_at');
    }
}
