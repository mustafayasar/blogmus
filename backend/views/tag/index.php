<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $filterModel common\models\Tag */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Tag;

$statuses   = Tag::$statuses;

$this->title = 'Etiketler';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-8">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i> Etiketler <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Yeni', ['create'], ['class' => 'btn btn-success btn-xs']) ?></h2>
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
