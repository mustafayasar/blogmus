<?php
use yii\db\Migration;

use common\models\User;
use common\models\Post;

class m210526_113939_posts extends Migration
{
    public function up()
    {
        $this->createTable('{{%post}}', [
            'id'                => $this->primaryKey(),
            'type'              => $this->tinyInteger(1)->defaultValue(Post::POST_TYPE_POST),
            'slug'              => $this->string(250)->notNull()->unique(),
            'title'             => $this->string(250)->notNull(),
            'image'             => $this->string(250)->notNull(),
            'description'       => $this->string(1500)->notNull(),
            'content'           => 'LONGTEXT',
            'comment_status'    => $this->tinyInteger()->notNull()->defaultValue(Post::COMMENT_STATUS_ACTIVE),
            'post_date'         => $this->dateTime(),
            'post_status'       => $this->tinyInteger()->notNull()->defaultValue(Post::POST_STATUS_DRAFT),
            'created_at'        => $this->integer()->notNull(),
            'updated_at'        => $this->integer()->notNull(),
        ], Yii::$app->params['dbTableOptions']);
    }

    public function down()
    {
        $this->dropTable('{{%post}}');
    }
}
