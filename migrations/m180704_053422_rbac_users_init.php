<?php

use yii\db\Migration;

/**
 * Создаем роли для RBAC.
 */
class m180704_053422_rbac_users_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создаем разрешения.
        $adminAccess = $auth->createPermission('adminAccess');
        $adminAccess->description = 'Админский доступ';

        // Сохранение разрешений в базу даннх.
        $auth->add($adminAccess);

        // Создадим роли админа, редактора и пользователя.
        $admin = $auth->createRole('admin');
        $editor = $auth->createRole('editor');
        $user = $auth->createRole('user');

        // запишем их в БД
        $auth->add($admin);
        $auth->add($editor);
        $auth->add($user);

        // Пропишем наследование ролей.
        $auth->addChild($editor, $user);
        $auth->addChild($admin, $editor);

        // Даем адимнам право редактировать пользователей.
        $auth->addChild($admin, $adminAccess);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);

        // Назначаем роль editor пользователю с ID 2
//        $auth->assign($editor, 2);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        return true;
    }
}
