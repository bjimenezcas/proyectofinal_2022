<?php

use kartik\datecontrol\Module;
use kartik\export\ExportMenu;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params-common.php'),
    require(__DIR__ . '/params-common.php')
);

$baseUrl = '/backend';
$config = [
    //'homeUrl' => '/panel',
    'id' => 'boda-panel',
    'name' => 'boda-panel',
    'version' => '2.0',
    'language' => 'es_es',
    'sourceLanguage' => 'es',
    'charset' => 'utf-8',
    'timeZone' => 'Europe/Madrid',
    'defaultRoute' => 'login',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',],
    'controllerNamespace' => 'backend\controllers',
    'modules' => [
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                Module::FORMAT_DATE => 'yyyy',
                Module::FORMAT_TIME => 'HH:mm:ss a',
                Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss a',
            ],
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:yyyy',
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            'autoWidget' => true,
            'autoWidgetSettings' => [
                Module::FORMAT_DATETIME => [],
                Module::FORMAT_TIME => [],
            ],
            'widgetSettings' => [
                Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker',
                    'options' => [
                        'dateFormat' => 'php:d-M-Y',
                        'options' => ['class' => 'form-control'],
                    ]
                ]
            ]

        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            'exportEncryptSalt' => 'D0F57BA601B10EE5D71EE18D93CFB7284BFEACF0'
        ],
        'dynagrid' => [
            //'bsVersion'=>'4',
            'class' => '\kartik\dynagrid\Module',
            'maxPageSize' => 1000,
            'dbSettings' => [
                'tableName' => 'web_tbl_dynagrid'
            ],
            'dbSettingsDtl' => [
                'tableName' => 'web_tbl_dynagrid_dtl'
            ],
            'dynaGridOptions' => [
                'toggleButtonGrid' => ['class' => 'btn-sm'],
                'toggleButtonFilter' => ['class' => 'btn-sm'],
                'toggleButtonSort' => ['class' => 'btn-sm'],
                'gridOptions' => [
                    'pjax' => false,
                    'responsive' => true,
                    'responsiveWrap' => false,
                    'export' => [
                        'options' => ['class' => 'btn btn-sm btn-default'],
                        //'label' => 'Pagina',
                        'fontAwesome' => true,
                        'target' => ExportMenu::TARGET_BLANK,
                        'showConfirmAlert' => false,

                    ],
                ]
            ]
            // other module settings
        ],
    ],
    'components' => [
        /**/

        'i18n' => [
            'translations' => [
                'kvexport' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/kartik-v/yii2-export/src/messages',
                ],


            ],
        ],
        'assetManager' => [


            'linkAssets' => false,
            'bundles' =>
                [


                    'dosamigos\google\maps\MapAsset' => [
                'options' => [
                    'key' => 'AIzaSyCsYMjR-45IKL3Csfhn3OUWC5PP1xJvhDs',
                    'language' => 'es',
                    'version' => '3.1.18'
                ]
            ],

            ],

        ],


        /* 
            Al añadir la siguiente configuracion del Request permitimos el acceso a las 3 direcciones ips del balanceador de carga
            Por otro lado añadimos el ipHeader => X-Forwarded-For para que Yii framework pueda tener acceso a la ip de la petición original 

        */
        'request' => [
            'baseUrl' => $baseUrl,
            'cookieValidationKey' => 'Panel Desarrollado por Constellation',
            'enableCsrfValidation' => false,
            
            'secureHeaders' => [
                'X-Forwarded-For',
                'X-Forwarded-Host',
                'X-Forwarded-Proto',
                'X-Proxy-User-Ip',
                'Front-End-Https',
            ],
            'ipHeaders' => [
                'X-Forwarded-For',
            ],
            'secureProtocolHeaders' => [
                'Front-End-Https' => ['on']
            ],
        ],
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect'
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ],
        'session' => [
            'name' => 'WebControlPanel',
            'class' => 'yii\web\Session',
            //'class' => 'yii\web\DbSession',
            'timeout' => 60 * 60 * 24 * 10,//10 days
            'cookieParams' => ['lifetime' => 60 * 60 * 24 * 10],//10 days
            'useCookies' => true,
            //'savePath' => __DIR__ . '/../tmp',
        ],
        'user' => [
            'identityClass' => 'common\models\login\Users',
            'class' => 'common\components\general\WebUser',
            'enableAutoLogin' => true,
            'autoRenewCookie' => true,
            'authTimeout' => 60 * 60 * 24 * 10, //tiempo, actual 10days
            'loginUrl' => ['login/lostsession'],
        ],
        'errorHandler' => [
            'errorAction' => 'login/error',
        ],/**/
        'urlManager' => [
            'scriptUrl'=>'/backend/index.php',
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
        'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => 'frontend/web',
            //'enablePrettyUrl' => true,
            //'showScriptName' => false,
        ],
    ],
    'params' => $params,

];
return $config;
