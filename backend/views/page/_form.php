<?php
/* @var $this yii\web\View */
/* @var $model backend\models\PostForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $managers [] */
/* @var $guides [] */
/* @var $teachers [] */
/* @var $countries [] */
/* @var $cities [] */
/* @var $towns [] */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Post;
use kartik\editors\Summernote;

$comment_statuses   = Post::$comment_statuses;
$post_statuses      = Post::$post_statuses;
?>
<div class="admin-form">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput() ?>

        <?= $model->_item->id > 0 ? $form->field($model, 'slug')->textInput() : '' ?>

        <?= $form->field($model, 'content')->widget(Summernote::class, [
            'options' => ['placeholder' => '']
        ]); ?>

<!--        <?= $form->field($model, 'post_date')->dropDownList($post_statuses) ?> -->


        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'comment_status')->dropDownList($comment_statuses) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'post_status')->dropDownList($post_statuses) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Kaydet', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>

