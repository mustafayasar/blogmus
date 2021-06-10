<?php
/* @var $this yii\web\View */
/* @var $limit */
/* @var $posts Post[] */

use common\models\Post;
use yii\helpers\Url;

$limit  = $limit ?? 6;

$posts  = Post::getNewItems($limit);
?>

<div class="post-list">
    <?php foreach ($posts as $post) { ?>
        <div class="post-item col-md-4">
            <div class="post-image">
                <img alt="<?= $post->title ?>" src="<?= Yii::$app->params['postImageUrl'].$post->image ?>" />
            </div>
            <h3 class="post-title"><a href="<?= Url::to(['post/view', 'slug' => $post->slug]) ?>" title="<?= $post->title ?>"><?= $post->title ?></a></h3>
            <div class="post-description">
                <?= $post->description ?>
            </div>
        </div>
    <?php } ?>
    <div class="clearfix"></div>
</div>
