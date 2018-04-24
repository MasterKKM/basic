<?php

use yii\db\Migration;

/**
 * Handles the creation of table `images`.
 */
class m180424_081542_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('images', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'file_name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('images');
    }
}
