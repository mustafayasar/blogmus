<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * Post model
 *
 * @property integer $id
 * @property integer $type
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $content
 * @property integer $comment_status
 * @property string $post_date
 * @property integer $post_status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Post extends ActiveRecord
{
    const POST_TYPE_PAGE  = 1;
    const POST_TYPE_POST  = 2;

    const POST_STATUS_DRAFT     = 3;
    const POST_STATUS_ACTIVE    = 1;
    const POST_STATUS_PASSIVE   = 2;
    const POST_STATUS_DELETED   = 9;

    const COMMENT_STATUS_ACTIVE    = 1;
    const COMMENT_STATUS_PASSIVE   = 2;

    public static $post_statuses    = [
        self::POST_STATUS_ACTIVE    => "Aktif",
        self::POST_STATUS_PASSIVE   => "Pasif",
        self::POST_STATUS_DRAFT     => "Taslak",
        self::POST_STATUS_DELETED   => "Silindi",
    ];

    public static $comment_statuses    = [
        self::COMMENT_STATUS_ACTIVE    => "Aktif",
        self::COMMENT_STATUS_PASSIVE   => "Pasif",
    ];

    public static $labels = [
        'id'                => 'ID',
        'title'             => 'Başlık',
        'description'       => 'Açıklama',
        'categories'        => 'Kategoriler',
        'tags'              => 'Etiketler',
        'image'             => 'Tanıtım Resmi',
        'content'           => 'İçerik',
        'comment_status'    => 'Yorum Yapabilme',
        'post_date'         => 'Yayın Tarihi',
        'post_status'       => 'Yayın Durumu',
        'created_at'        => 'Oluşturulma',
        'updated_at'        => 'Güncellenme',
    ];


    public function attributeLabels(): array
    {
        return self::$labels;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function getNewItems($limit = 6): array
    {
        return Post::getItems(0, 0,'new', $limit);
    }

    public static function getItems($category_id = 0, $tag_id = 0, $order = 'new', $limit = 6): array
    {
        $post   = Post::find()->andWhere(['type' => Post::POST_TYPE_POST, 'post_status' => Post::POST_STATUS_ACTIVE]);

        if ($category_id > 0) {
            $category_ids   = Category::getIdsWithChildren($category_id);
            $category_posts = PostCategory::find()->select('post_id')->where(['category_id' => $category_ids])->all();
            $category_posts = ArrayHelper::getColumn($category_posts, 'post_id');

            $post->andWhere(['id' => $category_posts]);
        }

        if ($tag_id > 0) {
            $tag_posts  = PostTag::find()->select('post_id')->where(['tag_id' => $tag_id])->all();
            $tag_posts  = ArrayHelper::getColumn($tag_posts, 'post_id');

            $post->andWhere(['id' => $tag_posts]);
        }

        if ($order == 'new') {
            $post->orderBy('id DESC');
        } elseif ($order == 'old') {
            $post->orderBy('id ASC');
        } elseif ($order == 'name_az') {
            $post->orderBy('name ASC');
        } elseif ($order == 'name_za') {
            $post->orderBy('name DESC');
        }

        return $post->limit($limit)->all();
    }

    public static function getItem($id, $slug = 0)
    {
        $post   = Post::find()->andWhere(['post_status' => Post::POST_STATUS_ACTIVE]);

        if ($id > 0) {
            $post->andWhere(['id' => $id]);
        } elseif (!empty($slug)) {
            $post->andWhere(['slug' => $slug]);
        } else {
            return false;
        }

        return $post->one();
    }

    public static function getContent($id, $slug = '')
    {
        $post   = Post::find()->andWhere(['post_status' => Post::POST_STATUS_ACTIVE]);

        if ($id > 0) {
            $post->andWhere(['id' => $id]);
        } elseif (!empty($slug)) {
            $post->andWhere(['slug' => $slug]);
        } else {
            return '';
        }

        $post   = $post->one();

        return isset($post['content']) ? $post['content'] : '';
    }


    public function getCategories(): \yii\db\ActiveQuery
    {
        return $this->hasMany(PostCategory::class, ['post_id' => 'id'])->with('category');
    }


    public function getTags(): \yii\db\ActiveQuery
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id'])->with('tag');
    }

}