<?php

use yii\db\Migration;

/**
 * Миграция добавляющая поле для даты создания записи.
 *   event_date - Дата снимка.
 *   create_at - Дата внесения снимка в базу.
 */
class m180624_110706_add_fields_in_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('image', 'create_at', $this->dateTime()->defaultValue('1971-05-09 20:15:00')->notNull());
        $this->addColumn('image', 'event_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('image', 'create_at');
        $this->dropColumn('image', 'event_date');

        return true;
    }


}
