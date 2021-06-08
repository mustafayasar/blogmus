<?php
namespace common\models;

use Yii;
use yii\base\BaseObject;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * PostTag model
 *
 * @property integer $post_id
 * @property integer $tag_id
 * @property integer $created_at
 */
class PostTag extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%post_tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp'  => [
                'class'                 => TimestampBehavior::class,
                'updatedAtAttribute'    => false,
            ],
        ];
    }

    public static function add($post_id, $tag_id): bool
    {
        $exists = PostTag::find()->where(['post_id' => $post_id, 'tag_id' => $tag_id])->count();

        if ($exists == 0) {
            $post_tag           = new PostTag();
            $post_tag->post_id  = $post_id;
            $post_tag->tag_id   = $tag_id;

            return $post_tag->save();
        }

        return true;
    }


    public function getPost(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getTag(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}