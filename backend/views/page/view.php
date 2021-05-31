<?php
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $managers [] */
/* @var $guides [] */

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Post;

$this->title = 'Sayfa Görüntüle';
$this->params['breadcrumbs'][] = ['label' => 'Sayfalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$comment_statuses   = Post::$comment_statuses;
$post_statuses      = Post::$post_statuses;
?>
<div class="col-md-5">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-eye"></i> <?= $model->title ?> <?= Html::a('Düzenle', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?= DetailView::widget([
                'model'         => $model,
                'formatter'     => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<span class="not-set">Yok</span>'],
                'attributes'    => [
                    'id',
                    'title',
                    'slug',
                    [
                        'attribute' => 'comment_status',
                        'value'     => function($model) use ($comment_statuses) {
                            return $comment_statuses[$model->comment_status];
                        }
                    ],
                    [
                        'attribute' => 'post_status',
                        'value'     => function($model) use ($post_statuses) {
                            return $post_statuses[$model->post_status];
                        }
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>


<div class="col-md-7">
    <div class="x_panel">
        <div class="x_title">
            <h4>Sayfa İçeriği</h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $model->content ?>
        </div>
    </div>
</div>
