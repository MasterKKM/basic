<?php

namespace app\models;

use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "section".
 *
 * @property int $id
 * @property string $name
 *
 * @property Image[] $images
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Раздел',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['section_id' => 'id']);
    }

    /**
     * Получить список всех разделов вида ['id'=>'name'].
     * @return array
     */
    public static function getAllSections()
    {
        $lines = static::find()->all();

        return ArrayHelper::map($lines, 'id', 'name');
    }
}
