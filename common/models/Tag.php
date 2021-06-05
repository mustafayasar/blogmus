<?php
namespace common\models;

use Yii;
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

}