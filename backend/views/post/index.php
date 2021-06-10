<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $filterModel common\models\Post */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Post;

$comment_statuses   = Post::$comment_statuses;
$post_statuses      = Post::$post_statuses;

$this->title = 'Yazılar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i> Yazılar <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Yeni', ['create'], ['class' => 'btn btn-success btn-xs']) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider'  => $dataProvider,
                    'filterModel'   => $filterModel,
                    'columns'       => [
                        [
                            'attribute'     => 'id',
                            'headerOptions' => ['style' => 'width:64px'],
                        ],
                        [
                            'attribute'     => 'categories',
                            'value'         => function($model) {
                                $text = null;

                                foreach ($model->categories as $post_category) {
                                    $text   .= $text ? ', ' : '';
                                    $text   .= $post_category->category->name;
                                }
                                return $text;
                            },
                            'filter'        => $comment_statuses,
                            'headerOptions' => ['style' => 'width:144px'],
                        ],
                        'title',
                        [
                            'attribute'     => 'comment_status',
                            'value'         => function($model) use ($comment_statuses) {
                                return $comment_statuses[$model->comment_status];
                            },
                            'filter'        => $comment_statuses,
                            'headerOptions' => ['style' => 'width:144px'],
                        ],
                        [
                            'attribute'     => 'post_status',
                            'value'         => function($model) use ($post_statuses) {
                                return $post_statuses[$model->post_status];
                            },
                            'filter'        => $comment_statuses,
                            'headerOptions' => ['style' => 'width:144px'],
                        ],
                        [
                            'class'         => 'yii\grid\ActionColumn',
                            'template'      => '{view} {update}',
                        ],
                    ]
                ]) ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
