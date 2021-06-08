<?php
use yii\db\Migration;

use common\models\Tag;

class m210531_143939_tags extends Migration
{
    public function up()
    {
        $this->createTable('{{%tag}}', [
            'id'            => $this->primaryKey(),
            'slug'          => $this->string(250)->notNull()->unique(),
            'name'          => $this->string(250)->notNull(),
            'description'   => $this->string(1000)->null(),
            'status'        => $this->tinyInteger()->notNull()->defaultValue(Tag::STATUS_ACTIVE),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ], Yii::$app->params['dbTableOptions']);
    }

    public function down()
    {
        $this->dropTable('{{%category}}');
    }
}
