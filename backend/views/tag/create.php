<?php
/* @var $this yii\web\View */
/* @var $model common\models\Tag */

$this->title = 'Etiket Oluştur';
$this->params['breadcrumbs'][] = ['label' => 'Etiketler', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-5">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-edit"></i> Etiket Oluştur</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>