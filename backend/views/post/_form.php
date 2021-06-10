<?php
/* @var $this yii\web\View */
/* @var $model backend\models\PostForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories [] */
/* @var $tags [] */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Post;
use kartik\editors\Summernote;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;

$comment_statuses   = Post::$comment_statuses;
$post_statuses      = Post::$post_statuses;
?>
<div class="admin-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'title')->textInput() ?>

            <?= $model->_item->id > 0 ? $form->field($model, 'slug')->textInput() : '' ?>

            <?= $form->field($model, 'description')->textarea() ?>

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

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?= Html::submitButton('Kaydet', ['class' => 'btn btn-success btn-block']) ?>
            </div>

            <?= $form->field($model, 'post_date')->widget(DateTimePicker::class, [
                'type' => DateTimePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format'    => 'yyyy-mm-dd hh:ii:ss'
                ]
            ])->label('Yayın Tarihi') ?>

            <?= $form->field($model, 'categories')->widget(Select2::class, [
                'data'      => $categories,
                'options'   => [
                    'placeholder'   => 'Kategori seçiniz..',
                    'multiple'      => true,
                ],
                'showToggleAll' => false
            ])->label('Kategori Seç') ?>

            <div style="margin-bottom: 20px;">
                <?= $form->field($model, 'image')->fileInput() ?>
                <?php if (!empty($model->image)) { ?>
                    <div>
                        <img src="<?=Yii::$app->params['postImageUrl'] ?><?=$model->image ?>" style="max-width: 250px; width: 100%;" />
                    </div>
                <?php } ?>
            </div>


            <?= $form->field($model, 'tags')->widget(Select2::class, [
                'data'          => $tags,
                'options'       => [
                    'placeholder'   => 'Etiket Seçiniz',
                    'multiple'      => true
                ],
                'showToggleAll' => false,
                'pluginOptions' => [
                    'tags'                  => true,
                    'tokenSeparators'       => [',']
                ],
            ])->label('Etiket Seç') ?>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>



