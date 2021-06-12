<?php
use yii\db\Migration;
use common\models\Comment;

class m210611_105900_comments extends Migration
{
    public function up()
    {
        $this->createTable('{{%comment}}', [
            'id'            => $this->primaryKey(),
            'post_id'       => $this->integer()->notNull(),
            'name'          => $this->string(150)->notNull(),
            'email'         => $this->string(150)->notNull(),
            'content'       => $this->text()->notNull(),
            'comment_date'  => $this->dateTime()->notNull(),
            'status'        => $this->tinyInteger()->notNull()->defaultValue(Comment::STATUS_PASSIVE),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ], Yii::$app->params['dbTableOptions']);
    }

    public function down()
    {
        $this->dropTable('{{%comment}}');
    }
}
