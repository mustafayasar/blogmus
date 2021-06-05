<?php
/* @var $this yii\web\View */
/* @var $model backend\models\TagForm */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Tag;

$statuses   = Tag::$statuses;
?>
<div class="admin-form">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $model->_item->id > 0 ? $form->field($model, 'slug')->textInput() : '' ?>

        <?= $form->field($model, 'description')->textarea(); ?>

        <?= $form->field($model, 'status')->dropDownList($statuses) ?>

        <div class="form-group">
            <?= Html::submitButton('Kaydet', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>

