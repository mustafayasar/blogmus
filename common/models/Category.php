<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

/**
 * Category model
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends ActiveRecord
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
        'parent_id'     => 'Üst Kategori',
        'name'          => 'Kategori Adı',
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
        return '{{%category}}';
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


    public static function getArray($except_id = 0, $parent_id = 0, $arr = [], $prf = '')
    {
        $categories = Category::find()->andWhere(['parent_id' => $parent_id])->andWhere(['status' => Category::STATUS_ACTIVE])->orderBy('name ASC')->all();

        $prf    = $parent_id > 0 ? $prf.'--' : '';

        foreach ($categories as $category) {
            if ($category->id != $except_id || (is_array($except_id) && in_array($category->id, $except_id))) {
                $arr[$category->id] = $prf.' '.$category->name;

                $arr    = self::getArray($except_id, $category->id, $arr, $prf);
            }
        }

        return $arr;
    }

    public static function getArrayWithSlug($parent_id = 0, $arr = [], $prf = '')
    {
        $categories = Category::find()->andWhere(['parent_id' => $parent_id])->andWhere(['status' => Category::STATUS_ACTIVE])->orderBy('name ASC')->all();

        $prf    = $parent_id > 0 ? $prf.'--' : '';

        foreach ($categories as $category) {
            $arr[$category->slug] = $prf.' '.$category->name;

            $arr    = self::getArrayWithSlug($category->id, $arr, $prf);
        }

        return $arr;
    }

    public static function getIdsWithChildren($id, &$arr = [])
    {
        $categories   = Category::find()->select('id')->andWhere(['parent_id' => $id])->andWhere(['status' => Category::STATUS_ACTIVE])->all();

        $arr[$id]  = $id;

        foreach ($categories as $category) {
            $arr[$category->id]  = $category->id;

            $arr    = self::getIdsWithChildren($category->id, $arr);
        }

        return $arr;
    }


    public function getParent(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    public function getChildren(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Category::class, ['parent_id' => 'id'])->with('children')->andWhere(['status' => Category::STATUS_ACTIVE])->orderBy('name ASC');
    }

}