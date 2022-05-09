<?php
    $Host = 'host.docker.internal';//local
return [
    'components' => [
        /**/
        'db' =>
            [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=' . $Host . ';port=3307;dbname=boda',
                'username' => 'userboda',
                'password' => 'Boda22',
                'charset' => 'utf8',
                'enableSchemaCache' => true,
                'schemaCacheDuration' => 3600,
                'schemaCache' => 'cache',
            ],
    ],
];