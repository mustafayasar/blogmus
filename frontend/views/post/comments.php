<?php
/* @var $this yii\web\View */
/* @var $post common\models\Comment */
/* @var $commentForm frontend\models\CommentForm */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Comment;
use common\my\Helper;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
?>
<div class="col-md-6 col-md-offset-3">

    <div class="comments">
        <h3 style="margin-bottom: 15px; color: #545353;">0 Yorum</h3>
        <p class="alert alert-warning">Bu içeriğe henüz yorum yapılmadı.</p>
    </div>

    <div class="comment-form-div">
        <h3 style="margin-bottom: 15px; color: #545353;">Yorum Yapın</h3>

        <?= \common\widgets\Alert::widget() ?>

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

        <?= $form->field($commentForm, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($commentForm, 'email') ?>

        <?= $form->field($commentForm, 'content')->textarea(['rows' => 6]) ?>

        <?= $form->field($commentForm, 'verifyCode')->widget(Captcha::class, [
            'template' => '<div class="row"><div class="col-md-3">{image}</div><div class="col-md-6">{input}</div></div>',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Yorumumu Kaydet', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>