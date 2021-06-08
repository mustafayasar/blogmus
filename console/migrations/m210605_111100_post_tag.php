<?php
use yii\db\Migration;

class m210605_111100_post_tag extends Migration
{
    public function up()
    {
        $this->createTable('{{%post_tag}}', [
            'post_id'       => $this->integer()->notNull(),
            'tag_id'        => $this->integer()->notNull(),
            'created_at'    => $this->integer()->notNull()
        ], Yii::$app->params['dbTableOptions']);

        $this->createIndex('post_tag-unique', 'post_tag', 'post_id, tag_id', 1);
    }

    public function down()
    {
        $this->dropTable('{{%post_tag}}');
    }
}
