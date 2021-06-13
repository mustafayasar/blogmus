<?php
/* @var $this yii\web\View */
/* @var $title */
/* @var $description */
/* @var $posts common\models\Post[] */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Post;
use common\my\Helper;

$this->title = $title;
$this->params['description']  = $description;
?>
<div class="posts">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="post-list">
        <?php if (count($posts) > 0) {
            $x = 0; ?>
            <?php foreach ($posts as $post) { ?>
                <div class="post-item col-md-4">
                    <div class="post-image">
                        <a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>" title="<?= $post->title ?>">
                            <img alt="<?= $post->title ?>" src="<?= Yii::$app->params['postImageUrl'].$post->image ?>" />
                        </a>
                    </div>
                    <h3 class="post-title"><a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>" title="<?= $post->title ?>"><?= $post->title ?></a></h3>
                    <div class="post-description">
                        <?= $post->description ?>
                    </div>
                    <div class="post-date">
                        <?= Helper::getDate($post->post_date) ?>
                    </div>
                </div>
            <?php $x++;} ?>

            <?= $x == 3 ? '<div class="clearfix"></div>' : ''; ?>

        <?php } else { ?>
            <div class="alert alert-warning">
                Bu kategoriye henüz yazı eklenmedi.
            </div>
        <?php } ?>
        <div class="clearfix"></div>
    </div>
</div>
