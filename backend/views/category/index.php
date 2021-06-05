<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $filterModel common\models\Category */
/* @var $categories common\models\Category[] */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Category;

$statuses   = Category::$statuses;

$this->title = 'Kategoriler';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-10">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i> Kategoriler <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Yeni', ['create'], ['class' => 'btn btn-success btn-xs']) ?></h2>
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
                            'attribute'     => 'parent_id',
                            'value'         => function($model) {
                                return $model->parent_id > 0 ? $model->parent->name : 'Yok';
                            },
                            'filter'        => $categories
                        ],
                        'name',
                        [
                            'attribute'     => 'status',
                            'value'         => function($model) use ($statuses) {
                                return $statuses[$model->status];
                            },
                            'filter'        => $statuses,
                            'headerOptions' => ['style' => 'width:144px'],
                        ],
                        [
                            'class'         => 'yii\grid\ActionColumn',
                            'template'      => '{view} {update} {delete}',
                        ],
                    ]
                ]) ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
