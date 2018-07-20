<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * Class Users для задач обработки нескольких пользователей.
 *
 * @package app\models
 */
class Users extends \dektrium\user\models\User
{
    /**
     * Получить список всех пользователей, имеющих фотографии.
     * @return array
     */
    public static function getAll()
    {
        $lines = static::find()->select('user.username, user.id')->innerJoin('image', 'image.user_id = user.id')->all();

        return ArrayHelper::map($lines, 'id', 'username');
    }
}
