<?php
/* @var $this yii\web\View */
/* @var $home_about */

use common\models\Post;
use yii\helpers\Url;

$this->title = 'Blogmus';
?>
<div class="site-index">
    <div class="home-about">
        <img src="/images/home-about-image.jpeg" alt="blogmus hakkında" align="left" />
        <h2>Blogmus</h2>
        <p>Blogmus, kendi siteni rahatlıkla kendin tasarlayabileceğin bir hazır site aracıdır. Az bir kod bilgisiyle, siteni kendin kurabilir ve tasarlayabilirsin. Php diliyle yazılmış bir alt yapıya sahip olan Blogmus, Yii Framework kullanılarak kodlanmıştır.  Php diliyle yazılmış bir alt yapıya sahip olan Blogmus, Yii Framework kullanılarak kodlanmıştır. </p>
        <a href="<?= Url::to(['post/view', 'slug' => 'hakkimizda']) ?>" title="Hakkımızda Sayfası" class="btn btn-default">Devamını Oku <i class="glyphicon glyphicon-triangle-right"></i> </a>
        <div class="clearfix"></div>
    </div>

    <div>
        <h2 style="text-align: center; font-size: 33px; margin-bottom: 20px;">Yeni Yazılar</h2>
        <?= $this->render('/elements/new-posts', ['limit' => 6]) ?>
    </div>

</div>
