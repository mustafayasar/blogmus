<?php

use yii\db\Migration;
use common\models\User;

class m21032021_184333_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

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
        ], $tableOptions);

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
