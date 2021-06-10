<?php
/* @var $this yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Category;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (isset($this->params['description'])) { ?>
        <meta name="description" content="<?= $this->params['description'] ?>" />
    <?php } ?>
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <div id="header">
        <div class="container">
            <h1>Blogmus</h1>
            <h3>Kendi siteni kendin tasarla!</h3>
        </div>
    </div>
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);

    $categories     = Category::getArrayWithSlug();
    $catMenuItems   = [];

    foreach ($categories as $slug => $name) {
        $catMenuItems[] = ['label' => $name, 'url' => Url::to(['post/category', 'slug' => $slug])];
    }

    $menuItems = [
        ['label' => 'Anasayfa', 'url' => ['/site/index']],
        ['label' => 'Hakkında', 'url' => ['/post/view', 'slug' => 'hakkinda']],
        ['label' => 'Yazılar', 'url' => ['/post/index']],
        ['label' => 'Kategoriler',
            'url'       => ['#'],
            'template'  => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
            'items'     => $catMenuItems,
        ],
        ['label' => 'İletişim', 'url' => ['/site/contact']],
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
        <div class="clearfix"></div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right">Blogmus ile oluşturuldu.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
