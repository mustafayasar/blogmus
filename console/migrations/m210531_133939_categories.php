<?php
use yii\db\Migration;

use common\models\Category;

class m210531_133939_categories extends Migration
{
    public function up()
    {
        $this->createTable('{{%category}}', [
            'id'            => $this->primaryKey(),
            'parent_id'     => $this->integer()->defaultValue(0)->notNull(),
            'slug'          => $this->string(250)->notNull()->unique(),
            'name'          => $this->string(250)->notNull(),
            'description'   => $this->string(1000)->null(),
            'status'        => $this->tinyInteger()->notNull()->defaultValue(Category::STATUS_ACTIVE),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ], Yii::$app->params['dbTableOptions']);
    }

    public function down()
    {
        $this->dropTable('{{%category}}');
    }
}
