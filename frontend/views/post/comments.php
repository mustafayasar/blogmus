<?php
/* @var $this yii\web\View */
/* @var $post_id */
/* @var $commentForm frontend\models\CommentForm */
/* @var $comments common\models\Comment[] */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Comment;
use common\my\Helper;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use YoHang88\LetterAvatar\LetterAvatar;

if ($post_id > 0) {
    $commentForm->post_id = $post_id;
}

$comment_count  = 0;

?>
<div class="col-md-6 col-md-offset-3">

    <div class="comments">
        <h3 style="margin-bottom: 15px; color: #545353;"><?= count($comments) ?> Yorum</h3>
        <?php if (count($comments) > 0) { ?>
            <?php foreach ($comments as $comment) { ?>
            <div class="comment">
                <div class="comment-avatar col-md-2">
                    <img src="<?= new LetterAvatar($comment->name, 'square', 128) ?>" alt="<?= $comment->name ?> avatar" />
                </div>
                <div class="comment-info col-md-10">
                    <div class="comment-name">
                        <h4><?= $comment->name ?></h4>
                    </div>
                    <div class="comment-content"><?= $comment->content ?></div>
                    <div class="comment-date"><?= Helper::getDate($comment->comment_date) ?></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php } ?>
        <?php } else { ?>
            <p class="alert alert-warning">Bu içeriğe henüz yorum yapılmadı.</p>
        <?php } ?>
    </div>

    <div class="comment-form-div">
        <h3 style="margin-bottom: 15px; color: #545353;">Yorum Yapın</h3>

        <?= \common\widgets\Alert::widget() ?>

        <?php $form = ActiveForm::begin(['id' => 'contact-form', 'action' => Url::to(['post/save-comment'])]); ?>

        <?= $form->field($commentForm, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($commentForm, 'email') ?>

        <?= $form->field($commentForm, 'content')->textarea(['rows' => 6]) ?>

        <?= $form->field($commentForm, 'verifyCode')->widget(Captcha::class, [
            'template' => '<div class="row"><div class="col-md-3">{image}</div><div class="col-md-6">{input}</div></div>',
        ]) ?>

        <div class="form-group">
            <?= $form->field($commentForm, 'post_id')->label(false)->hiddenInput() ?>
            <?= Html::submitButton('Yorumumu Kaydet', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>