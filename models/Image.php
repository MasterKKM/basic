<?php

namespace app\models;

use Imagine\Gd\Imagine;
use Yii;
use dektrium\user\models\User;
use yii\imagine\Image as ImageHelper;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_name
 * @property string $text
 *
 * @property User $user
 */
class Image extends \yii\db\ActiveRecord
{
    public $file = NULL;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'file_name'], 'required'],
            [['user_id'], 'integer'],
            [['text'], 'string'],
            [['file_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['file'], 'file', 'extensions' => 'jpg, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'file_name' => 'File Name',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Сохранение с сохранением загруженного файла.
     * @param bool $runValidation проверка перед запиьсью.
     * @param array $attributeNames Список атрибутов для записи.
     * @return bool Результат сохранения(удачно/не удачно).
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if (parent::save($runValidation, $attributeNames)) {
            if ($this->file !== NULL) {
                // Если файл есть сохраняем.
                $path = Yii::getAlias('@runtime/upload');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $fileName = $path . '/image_' . $this->id . '.png';
                if (file_exists($fileName)) {
                    unlink($fileName);
                }

                // Сохранение с перерекодированием в png.
                ImageHelper::getImagine()->open($this->file->tempName)->save($fileName);
            }
            return true;
        }

        return false;
    }
}
