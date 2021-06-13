<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * Comment model
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $name
 * @property string $email
 * @property string $content
 * @property string $comment_date
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Comment extends ActiveRecord
{
    const STATUS_ACTIVE    = 1;
    const STATUS_PASSIVE   = 2;
    const STATUS_WAITING   = 3;
    const STATUS_DELETED   = 9;

    public static $statuses    = [
        self::STATUS_ACTIVE     => "Onaylandı",
        self::STATUS_PASSIVE    => "Reddedildi",
        self::STATUS_WAITING    => "Onay Bekliyor",
        self::STATUS_DELETED    => "Silindi",
    ];

    public static $labels = [
        'id'            => 'ID',
        'post_id'       => 'İçerik',
        'name'          => 'Ad Soyad',
        'email'         => 'Mail Adresi',
        'content'       => 'Yorumunuz',
        'comment_date'  => 'Yorum Zamanı',
        'status'        => 'Durum',
        'created_at'    => 'Oluşturulma',
        'updated_at'    => 'Güncellenme',
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
        return '{{%comment}}';
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


    public static function getItems($post_id = 0, $order = 'new'): array
    {
        $post   = Comment::find()->andWhere(['post_id' => $post_id, 'status' => Comment::STATUS_ACTIVE]);

        if ($order == 'new') {
            $post->orderBy('id DESC');
        } elseif ($order == 'old') {
            $post->orderBy('id ASC');
        }

        return $post->all();
    }

    public function getPost(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }
}