<?php
/* @var $this yii\web\View */
/* @var $model common\models\Category */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Category;

$this->title = 'Kategori Görüntüle';
$this->params['breadcrumbs'][] = ['label' => 'Kategoriler', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$statuses   = Category::$statuses;
?>
<div class="col-md-6">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-eye"></i> <?= $model->name ?> <?= Html::a('Düzenle', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?= DetailView::widget([
                'model'         => $model,
                'formatter'     => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<span class="not-set">Yok</span>'],
                'attributes'    => [
                    'id',
                    [
                        'attribute' => 'parent_id',
                        'value'     => function($model) {
                            return $model->parent_id > 0 ? $model->parent->name : 'Yok';
                        }
                    ],
                    'name',
                    'slug',
                    'description',
                    [
                        'attribute' => 'status',
                        'value'     => function($model) use ($statuses) {
                            return $statuses[$model->status];
                        }
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>