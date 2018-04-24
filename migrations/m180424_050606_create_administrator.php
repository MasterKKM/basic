<?php

use yii\db\Migration;

/**
 * Создаем пользователя administrator.
 */
class m180424_050606_create_administrator extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('user', [
            'username',
            'email',
            'password_hash',
            'auth_key',
            'confirmed_at',
            'unconfirmed_email',
            'blocked_at',
            'registration_ip',
            'created_at',
            'updated_at',
            'flags',
            'last_login_at'
        ], [
            [
            'administrator',
            'b@b.b',
            '$2y$10$9CM5bRRZWQRPtdY35Qc/zOLhFivT8pFtmGwY8lpsrfU3gazBm5q/6',
            'zO2ZvErMuVpCfxrHMDfNaSxaXr3vl78W',
            '1524542896',
            null,
            null,
            '192.168.100.1',
            '1524542896',
            '1524542896',
            '0',
            '1524546599'
                ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['in', 'username', ['administrator']]);
        return true;
    }

}
