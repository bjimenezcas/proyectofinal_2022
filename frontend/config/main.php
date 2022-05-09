<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params-common.php'),
    require(__DIR__ . '/params-common.php'),
);

use \yii\web\Request;


$config = [
    'id' => 'frontend',
    'language' => 'es-es',
    'sourceLanguage' => 'es',
    'charset' => 'utf-8',
    'timeZone' => 'Europe/Madrid',
    'defaultRoute' => 'main/index',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'session' => [
            'name' => 'frontend',
            //'savePath' => __DIR__ . '/../tmp',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => false,
            'linkAssets' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'main/error',
        ],
        /**/
        'urlManager' => [
            'scriptUrl'=>'/index.php',
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            //'suffix' => '.php',

            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],/**/
    ],
    'params' => $params,
];


return $config;
