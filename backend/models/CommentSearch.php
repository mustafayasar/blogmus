<?php
namespace backend\models;

use common\models\Category;
use common\models\Comment;
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
class CommentSearch extends Tag
{
    public $post_id;
    public $name;
    public $email;
    public $status;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['name', 'email'], 'string'],
                [['post_id', 'status'], 'integer'],
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
        $query  = Comment::find()->with('post');

        $dataProvider   = new ActiveDataProvider([
            'query'         => $query,
            'sort'          => [
                'attributes'    => ['id', 'name'],
                'defaultOrder'  => ['id' => SORT_DESC]
            ],
            'pagination'    => ['pageSize' => 26]
        ]);

        if (!($this->load($params))) {
            $query->andFilterWhere(['!=', 'status', Comment::STATUS_DELETED]);

            return $dataProvider;
        }

        if ($this->post_id > 0) {
            $query->andFilterWhere(['post_id' => $this->post_id]);
        }

        if ($this->name != '') {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }

        if ($this->name != '') {
            $query->andFilterWhere(['like', 'email', $this->name]);
        }

        if ($this->status > 0) {
            $query->andFilterWhere(['status' => $this->status]);
        }

        return $dataProvider;
    }
}