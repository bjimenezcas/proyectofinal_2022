<?php
$LinkAssets = true;
    
$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/mail.php'), [
        'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'i18n' => [
            'translations' => [

            ],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
            ],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //I access  \Yii::$app->authManager.
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'defaultDuration' => 60 * 60 * 24,
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => false,
            'linkAssets' => $LinkAssets,
            'bundles' => [
            ]

        ],
    ],
]);
return $config;