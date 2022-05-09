<?php

$params = array_merge(
    require(__DIR__ . '/params-local.php')
);

$baseUrl = '';
$config = [
    'components' => [

        'request' => [
            'baseUrl' => $baseUrl,
            'cookieValidationKey' => '8Gjrd4Ff3MsQ3ZXAaEPkoU4D2hYgY20a',
            'enableCsrfValidation' => false,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'microtime'=>true,
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '172.*.*.*'],//this is local
        'allowedHosts' => ['host.docker.internal'],
        //'allowedHosts' => [],
        'historySize' => 1000,
        //'allowedIPs' => ['127.0.0.1','62.14.196.157']
    ];
}
return $config;
