<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Post model
 *
 * @property integer $id
 * @property integer $type
 * @property string $slug
 * @property string $title
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
        self::POST_STATUS_DRAFT     => "Taslak",
        self::POST_STATUS_ACTIVE    => "Aktif",
        self::POST_STATUS_PASSIVE   => "Pasif",
        self::POST_STATUS_DELETED   => "Silindi",
    ];

    public static $comment_statuses    = [
        self::COMMENT_STATUS_ACTIVE    => "Aktif",
        self::COMMENT_STATUS_PASSIVE   => "Pasif",
    ];

    public static $labels = [
        'id'                => 'ID',
        'title'             => 'Başlık',
        'content'           => 'İçerik',
        'comment_status'    => 'Yorum Yapabilme',
        'post_date'         => 'Yayın Tarihi',
        'post_status'       => 'Yayın Durumu',
        'created_at'        => 'Oluşturulma Z.',
        'updated_at'        => 'Güncellenme Z.',
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

}