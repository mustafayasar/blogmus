<?php
namespace backend\models;

use common\models\Category;
use common\models\Tag;
use Yii;
use yii\base\BaseObject;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use common\models\Post;
use yii\helpers\ArrayHelper;

/**
 * Class TagSearch
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $updated_at
 *
 * @package backend\models
 */
class TagSearch extends Tag
{
    public $id;
    public $name;
    public $status;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['name'], 'string'],
                [['id', 'status'], 'integer']
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
        $query  = Tag::find();

        $dataProvider   = new ActiveDataProvider([
            'query'         => $query,
            'sort'          => [
                'attributes'    => ['id', 'name'],
                'defaultOrder'  => ['name' => SORT_ASC]
            ],
            'pagination'    => ['pageSize' => 26]
        ]);

        if (!($this->load($params))) {
            $query->andFilterWhere(['!=', 'status', Tag::STATUS_DELETED]);

            return $dataProvider;
        }

        if ($this->id > 0) {
            $query->andFilterWhere(['id' => $this->id]);
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