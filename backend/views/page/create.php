<?php
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $managers [] */
/* @var $guides [] */
/* @var $teachers [] */
/* @var $countries [] */
/* @var $cities [] */
/* @var $towns [] */

$this->title = 'Sayfa Oluştur';
$this->params['breadcrumbs'][] = ['label' => 'Sayfalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-8">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-edit"></i> Sayfa Oluştur</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $this->render('_form', [
                'model'     => $model
            ]) ?>
        </div>
    </div>
</div>