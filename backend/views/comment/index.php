<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $filterModel common\models\Post */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Comment;

$statuses   = Comment::$statuses;

$this->title = 'Yorumlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i> Yorumlar</h2>
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
                        'name',
                        [
                            'attribute'     => 'post_id',
                            'value'         => function($model) {
                                return $model->post->title;
                            },
                        ],
                        [
                            'format'    => 'html',
                            'attribute' => 'status',
                            'value'     => function($model) use ($statuses) {
                                if ($model->status == Comment::STATUS_DELETED) {
                                    return '<a  href="'.Url::to(['comment/confirm', 'id' => $model->id]).'" data-confirm="Yorumu onaylamak istediğinize emin misiniz?">Silindi</a>';
                                } elseif ($model->status == Comment::STATUS_PASSIVE) {
                                    return '<a  href="'.Url::to(['comment/confirm', 'id' => $model->id]).'" data-confirm="Yorumu onaylamak istediğinize emin misiniz?">Reddedildi</a>';
                                } elseif ($model->status == Comment::STATUS_WAITING) {
                                    return 'Onay Bekliyor 
                                    <a href="'.Url::to(['comment/confirm', 'id' => $model->id]).'" data-confirm="Yorumu onaylamak istediğinize emin misiniz?"><i class="glyphicon glyphicon-thumbs-up"></i></a>
                                    <a href="'.Url::to(['comment/reject', 'id' => $model->id]).'" data-confirm="Yorumu pasifleştirmek istediğinize emin misiniz?"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                                    ';
                                } elseif ($model->status == Comment::STATUS_ACTIVE) {
                                    return '<a href="'.Url::to(['comment/reject', 'id' => $model->id]).'" data-confirm="Yorumu pasifleştirmek istediğinize emin misiniz?">Onaylandı</a>';
                                } else {
                                    return '';
                                }
                            },
                            'filter'        => $statuses,
                            'headerOptions' => ['style' => 'width:144px'],
                        ],
                        [
                            'class'         => 'yii\grid\ActionColumn',
                            'template'      => '{view} {delete}',
                        ],
                    ]
                ]) ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
