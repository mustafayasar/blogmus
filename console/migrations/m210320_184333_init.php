<?php

use yii\db\Migration;
use common\models\User;

class m210320_184333_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id'                    => $this->primaryKey(),
            'username'              => $this->string()->notNull()->unique(),
            'auth_key'              => $this->string(32)->notNull(),
            'password_hash'         => $this->string()->notNull(),
            'password_reset_token'  => $this->string()->unique(),
            'email'                 => $this->string()->notNull()->unique(),
            'status'                => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'            => $this->integer()->notNull(),
            'updated_at'            => $this->integer()->notNull(),
        ], Yii::$app->params['dbTableOptions']);

        $user           = new User();
        $user->username = 'admin';
        $user->email    = 'blogmus@blogmus.com';
        $user->status   = User::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->setPassword('merhaba9090');
        $user->save();
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
