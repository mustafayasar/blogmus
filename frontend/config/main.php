<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'            => 'blogmus-frontend',
    'name'          => 'Blogmus',
    'basePath'      => dirname(__DIR__),
    'bootstrap'     => ['log'],
    'controllerNamespace'   => 'frontend\controllers',
    'components'    => [
        'request'   => [
            'csrfParam'     => '_csrf-blogmus',
        ],
        'user'      => [
            'identityClass'     => 'common\models\User',
            'enableAutoLogin'   => true,
            'identityCookie'    => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session'   => [
            'name'  => 'blogmus-cms',
        ],
        'log'       => [
            'traceLevel'    => YII_DEBUG ? 3 : 0,
            'targets'       => [
                [
                    'class'     => 'yii\log\FileTarget',
                    'levels'    => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler'  => [
            'errorAction'       => 'site/error',
        ],
        'urlManager'    => [
            'enablePrettyUrl'   => true,
            'showScriptName'    => false,
            'rules' => [
                'yazilar'           => 'post/index',
                'kategori/<slug>'   => 'post/category',
                'etiket/<slug>'     => 'post/tag',
                '<slug>'            => 'post/view',
            ],
        ],
    ],
    'language'  => 'tr-TR',
    'params'    => $params,
];
