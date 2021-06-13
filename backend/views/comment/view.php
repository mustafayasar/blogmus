<?php
/* @var $this yii\web\View */
/* @var $model common\models\Comment */

use yii\widgets\DetailView;
use common\models\Comment;

$this->title = 'Yorum Görüntüle';
$this->params['breadcrumbs'][] = ['label' => 'Yorumlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$statuses   = Comment::$statuses;
?>
<div class="col-md-6">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-eye"></i> <?= $model->name ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?= DetailView::widget([
                'model'         => $model,
                'formatter'     => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<span class="not-set">Yok</span>'],
                'attributes'    => [
                    'id',
                    [
                        'attribute' => 'post_id',
                        'value'     => function($model) {
                            return $model->post->title;
                        }
                    ],
                    'name',
                    'email',
                    'content',
                    'comment_date',
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