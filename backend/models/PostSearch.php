<?php
namespace backend\models;

use Yii;
use yii\base\BaseObject;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use common\models\Post;
use yii\helpers\ArrayHelper;

/**
 * Class PostSearch
 *
 * @property integer $id
 * @property string $title
 * @property integer $comment_status
 * @property integer $post_status
 *
 * @package backend\models
 */
class PostSearch extends Post
{
    public $id;

    public $title;
    public $comment_status;
    public $post_status;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['title'], 'string'],
                [['id', 'comment_status', 'post_status'], 'integer']
            ]
        );
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $type): ActiveDataProvider
    {
        $query  = Post::find()->andFilterWhere(['type' => $type]);

        $dataProvider   = new ActiveDataProvider([
            'query'         => $query,
            'sort'          => [
                'attributes'    => ['id', 'title', 'post_date'],
                'defaultOrder'  => ['id' => SORT_DESC]
            ],
            'pagination'    => ['pageSize' => 26]
        ]);

        if (!($this->load($params))) {
            $query->andFilterWhere(['!=', 'post_status', Post::POST_STATUS_DELETED]);

            return $dataProvider;
        }

        if ($this->id > 0) {
            $query->andFilterWhere(['id' => $this->id]);
        }

        if ($this->title != '') {
            $query->andFilterWhere(['like', 'title', $this->title]);
        }

        if ($this->comment_status > 0) {
            $query->andFilterWhere(['comment_status' => $this->comment_status]);
        }

        if ($this->post_status > 0) {
            $query->andFilterWhere(['post_status' => $this->post_status]);
        }

        return $dataProvider;
    }
}