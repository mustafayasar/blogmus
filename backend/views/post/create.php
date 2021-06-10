<?php
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $categories [] */
/* @var $tags [] */

$this->title = 'Yazı Oluştur';
$this->params['breadcrumbs'][] = ['label' => 'Yazılar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$model->post_date   = empty($model->post_date) ? date("Y-m-d H:i:s") : $model->post_date;
?>
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-edit"></i> Yazı Oluştur</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $this->render('_form', [
                'model'         => $model,
                'categories'    => $categories,
                'tags'          => $tags,
            ]) ?>
        </div>
    </div>
</div>