<?php

$params = array_merge(
    require(__DIR__ . '/params-prod.php')
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
                ]
            ],
        ],
    ],

];
return $config;
