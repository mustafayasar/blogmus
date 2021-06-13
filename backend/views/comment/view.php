<?php
/* @var $this yii\web\View */
/* @var $model common\models\Comment */

use yii\widgets\DetailView;
use common\models\Comment;
use yii\helpers\Url;

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
                        }
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>

        </div>
    </div>
</div>