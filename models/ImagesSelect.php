<?php

namespace app\models;

use yii\base\Model;

/**
 * Модель для формы отбора фотографий.
 */
class ImagesSelect extends Model
{
    public $selectDate = null;
    public $selectSection = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['selectDate'], 'string'],
            [['selectSection'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'selectDate' => 'Дата события',
            'selectSection' => 'Раздел',
        ];
    }
}