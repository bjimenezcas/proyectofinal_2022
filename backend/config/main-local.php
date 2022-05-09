<?php

$params = array_merge(
    require(__DIR__ . '/params-local.php')
);
$config = [
    'params' => $params,
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'microtime' => true,
                ],
            ],
        ],
    ],
];
$true = true;

if (YII_ENV_DEV && $true) {
    $config['bootstrap'][] = 'debug';

    $ServerName = $_SERVER['SERVER_NAME'];
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1'],//this is local
        'allowedHosts' => ['host.docker.internal'],
        'historySize' => 3000,
        'defaultPanel' => 'log',
        'enableDebugLogs' => false,
        'traceLine' => '<a href="phpstorm://open?file={file}&line={line}">{file}:{line}</a>',
    
    ];

}

return $config;
