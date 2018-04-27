<?php

namespace app\models;

use Yii;
use dektrium\user\models\User;
use yii\imagine\Image as ImageHelper;
use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_name
 * @property string $text
 * @property yii\web\UploadedFile $file
 *
 * @property User $user
 */
class Image extends \yii\db\ActiveRecord
{
    public $file = NULL;
    private $keyTable = [
        0 => ['x' => 30, 'y' => 30],
        1 => ['x' => 400, 'y' => 300],
        2 => ['x' => 800, 'y' => 600]
    ];

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
            [['text', 'file_name'], 'filter', 'filter' => function ($value) {
                return strip_tags($value);
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Владелец',
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
     * Сохранение с перерекодированием в png загруженного файла.
     * @param bool $runValidation проверка перед запиьсью.
     * @param array $attributeNames Список атрибутов для записи.
     * @return bool Результат сохранения(удачно/не удачно).
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if (parent::save($runValidation, $attributeNames)) {
            if (!empty($this->file)) {
                // Если файл есть сохраняем.
                $path = Yii::getAlias('@runtime/upload');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                    mkdir($path . '/buff', 0777, true);
                }
                $fileName = $path . '/image_' . $this->id . '.png';
                $img = ImageHelper::getImagine()->open($this->file->tempName);
                $this->deleteImages();
                $img->save($fileName);
            }
            return true;
        }

        return false;
    }

    /**
     * @param $name string Имя изображения.
     * @return string полное имя файла изображения.
     */
    public function getThumb($name)
    {
        $path = Yii::getAlias('@runtime/upload');
        preg_match_all('/(\d+)/', $name, $tab);
        $id = $tab[0][0];
        $baseName = $path . '/image_' . $id . '.png';
        if (count($tab[0]) == 1) {
            if (file_exists($baseName)) {
                // Если файл существует, выдаем.
                return $baseName;
            }
            return NULL;
        }
        $key = (int)$tab[0][1];
        $rezName = $path . '/buff/image_' . $id . '_' . $key . '.png';
        if (file_exists($rezName)) {
            // Если файл существует, выдаем.
            return $rezName;
        }
        // Проверяем задан ли такой ресайз и базовая картинка.
        if (!empty($this->keyTable[$key]) && file_exists($baseName)) {
            if (!file_exists($rezName)) {
                $pos = $this->keyTable[$key];
                ImageHelper::getImagine()->open($baseName)->thumbnail(new Box($pos['x'], $pos['y']), ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($rezName);

                return $rezName;
            }
        }

        return NULL;
    }

    /**
     * Удаляем все файлы данной картинки.
     */
    private function deleteImages()
    {
        // Удаляем основной файл.
        $fileName = Yii::getAlias('@runtime/upload') . '/image_' . $this->id . '.png';
        if (file_exists($fileName)) {
            unlink($fileName);
        }

        // Удаляем ресайзы.
        $pathName = Yii::getAlias('@runtime/upload/buff') . '/image_' . $this->id . '_';
        $tabnames = [];

        foreach ($this->keyTable as $i => $val) {
            $tabnames[] = $pathName . $i . '.png';
        }

        foreach ($tabnames as $fileName) {
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }
    }

    public function delete()
    {
        $this->deleteImages();
        return parent::delete();
    }
}
