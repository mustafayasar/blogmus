<?php
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $categories common\models\Category[] */

$this->title = 'Kategori Oluştur';
$this->params['breadcrumbs'][] = ['label' => 'Kategoriler', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-5">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-edit"></i> Kategori Oluştur</h2>
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