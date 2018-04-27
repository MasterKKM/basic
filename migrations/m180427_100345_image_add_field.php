<?php

use yii\db\Migration;

/**
 * Добавляем поле определющее видимость картинки (все/только зарегистрированные);
 */
class m180427_100345_image_add_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('image', 'free', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('image', 'free');

        return true;
    }
}
