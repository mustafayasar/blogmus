<?php
namespace backend\models;

use common\models\Category;
use Yii;
use yii\base\BaseObject;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use common\models\Post;
use yii\helpers\ArrayHelper;

/**
 * Class CategorySearch
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property integer $status
 * @property integer $updated_at
 *
 * @package backend\models
 */
class CategorySearch extends Category
{
    public $id;

    public $parent_id;
    public $name;
    public $status;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['name'], 'string'],
                [['id', 'parent_id', 'status'], 'integer']
            ]
        );
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query  = Category::find();

        $dataProvider   = new ActiveDataProvider([
            'query'         => $query,
            'sort'          => [
                'attributes'    => ['id', 'name'],
                'defaultOrder'  => ['name' => SORT_ASC]
            ],
            'pagination'    => ['pageSize' => 26]
        ]);

        if (!($this->load($params))) {
            $query->andFilterWhere(['!=', 'status', Category::STATUS_DELETED]);

            return $dataProvider;
        }

        if ($this->id > 0) {
            $query->andFilterWhere(['id' => $this->id]);
        }

        if ($this->parent_id > 0) {
            $query->andFilterWhere(['parent_id' => $this->parent_id]);
        }

        if ($this->name != '') {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }

        if ($this->status > 0) {
            $query->andFilterWhere(['status' => $this->status]);
        }

        return $dataProvider;
    }
}