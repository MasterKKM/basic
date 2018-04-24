<?php

use dektrium\user\migrations\Migration;

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
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'file_name' => $this->string()->notNull(),
            'text' => $this->text(),
        ], $this->tableOptions);
        $this->createIndex('idx-image-user_id', 'image', 'user_id');
        $this->addForeignKey('fk-image-user', 'image', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('image');
    }
}
