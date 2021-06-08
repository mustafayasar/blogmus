<?php
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $categories [] */
/* @var $tags [] */

use yii\helpers\Html;

$this->title = 'Yazı Düzenle';
$this->params['breadcrumbs'][] = ['label' => 'Yazılar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-edit"></i> Yazı Düzenle</h2>
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