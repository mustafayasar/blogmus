<?php
use yii\db\Migration;

class m210605_111100_post_category extends Migration
{
    public function up()
    {
        $this->createTable('{{%post_category}}', [
            'post_id'       => $this->integer()->notNull(),
            'category_id'   => $this->integer()->notNull(),
            'created_at'    => $this->integer()->notNull()
        ], Yii::$app->params['dbTableOptions']);

        $this->createIndex('post_category-unique', 'post_category', 'post_id, category_id', 1);
    }

    public function down()
    {
        $this->dropTable('{{%post_category}}');
    }
}
