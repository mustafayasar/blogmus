<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * PostCategory model
 *
 * @property integer $post_id
 * @property integer $category_id
 * @property integer $created_at
 */
class PostCategory extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%post_category}}';
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


    public static function add($post_id, $category_id): bool
    {
        $exists = PostCategory::find()->where(['post_id' => $post_id, 'category_id' => $category_id])->count();

        if ($exists == 0) {
            $post_category              = new PostCategory();
            $post_category->post_id     = $post_id;
            $post_category->category_id = $category_id;

            return $post_category->save();
        }

        return true;
    }


    public function getPost(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}