<?php
/* @var $this yii\web\View */
/* @var $post common\models\Post */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Post;
use common\my\Helper;

$this->title = $post->title;
?>
<div class="post-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div>
        <?= $post->content ?>
    </div>

    <?php if ($post->type == Post::POST_TYPE_POST) { ?>
        <div class="post-info">
            <div class="post-date"><i class="glyphicon glyphicon-time"></i> <?= $post->post_date ? Helper::getDate($post->post_date) . ' yayınlandı.' : '' ; ?></div>
            <?php if (count($post->categories) > 0) {
                $text = '';

                foreach ($post->categories as $post_category) {
                    $text   .= !empty($text) ? ', ': ' ';

                    $text   .= '<a href="'.Url::to(['post/category', 'slug' => $post_category->category->slug]).'" title="'.$post_category->category->name.'">'.$post_category->category->name.'</a>';
                }
                ?>
                <div class="post-categories"><i class="glyphicon glyphicon-folder-open"></i> <?= $text ?></div>
            <?php } ?>
            <?php if (count($post->tags) > 0) {
                $text = '';

                foreach ($post->tags as $post_tag) {
                    $text   .= !empty($text) ? ', ': ' ';

                    $text   .= '<a href="'.Url::to(['post/tag', 'slug' => $post_tag->tag->slug]).'" title="'.$post_tag->tag->name.'">'.$post_tag->tag->name.'</a>';
                }
                ?>
                <div class="post-tags"><i class="glyphicon glyphicon-tags"></i> <?= $text ?></div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
