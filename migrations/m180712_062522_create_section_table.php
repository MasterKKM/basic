<?php

use yii\db\Migration;

/**
 * Создаем таблицу `section`. Формируем ее связь с таблицей `image`.
 */
class m180712_062522_create_section_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('section', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
        ], 'DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

        // Создаем первую запись - общий раздел.
        $this->batchInsert('section', ['name'], [['name' => 'Общий раздел']]);

        // Добавляем поле связи в таблицу изображений.
        $this->addColumn('image', 'section_id', $this->integer()->notNull()->defaultValue(1));
        $this->createIndex('ind_image_section_id', 'image', 'section_id');
        $this->addForeignKey('fk_image_section_id', 'image', 'section_id', 'section', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_image_section_id', 'image');
        $this->dropColumn('image', 'section_id');
        $this->dropTable('section');
    }
}
