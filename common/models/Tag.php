<?php
namespace common\models;

use common\my\Helper;
use Yii;
use yii\base\BaseObject;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Tag model
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Tag extends ActiveRecord
{
    const STATUS_ACTIVE    = 1;
    const STATUS_PASSIVE   = 2;
    const STATUS_DELETED   = 9;

    public static $statuses    = [
        self::STATUS_ACTIVE    => "Aktif",
        self::STATUS_PASSIVE   => "Pasif",
        self::STATUS_DELETED   => "Silindi",
    ];

    public static $labels = [
        'id'            => 'ID',
        'name'          => 'Etiket Adı',
        'description'   => 'Açıklama',
        'status'        => 'Durum',
        'created_at'    => 'Oluşturulma Z.',
        'updated_at'    => 'Güncellenme Z.',
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
        return '{{%tag}}';
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

    public static function getArray($except_id = 0): array
    {
        $tags   = Tag::find()->orderBy('name ASC')->all();
        $arr    = [];

        foreach ($tags as $tag) {
            if ($tag->id != $except_id || (is_array($except_id) && in_array($tag->id, $except_id))) {
                $arr[$tag->id] = $tag->name;
            }
        }

        return $arr;
    }



    public static function add($tag)
    {
        $slug   = Helper::slugify($tag);

        $exists = Tag::find()->where(['slug' => $slug])->one();

        if (!$exists) {
            $new_tag        = new Tag();
            $new_tag->name  = $tag;
            $new_tag->slug  = $slug;

            if ($new_tag->save()) {
                return $new_tag->id;
            }

            return false;
        }

        return $exists->id;
    }

}