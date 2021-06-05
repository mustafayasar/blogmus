<?php
/* @var $this yii\web\View */
/* @var $model backend\models\CategoryForm */
/* @var $categories common\models\Category[] */

$this->title = 'Kategori Düzenle';
$this->params['breadcrumbs'][] = ['label' => 'Kategoriler', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-5">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-edit"></i> Kategori Düzenle (<?= $model->name ?>)</h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <?= $this->render('_form', [
                'model'         => $model,
                'categories'    => $categories
            ]) ?>
        </div>
    </div>
</div>