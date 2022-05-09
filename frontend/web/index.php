<?php
$Environment = $_SERVER["Environment"];//local,prod,dev,pre
$Debuger = isset($_SERVER["Debuger"]) ? $_SERVER["Debuger"] : false;//true,false
if ($Environment == 'local' && $Debuger == 'true') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
} else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'prod');
    $_SERVER['HTTPS'] = 'on';
}

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../config/main.php'),
        require(__DIR__ . '/../../common/config/db-local.php'),
        require(__DIR__ . '/../config/main-local.php')
    );

$application = new yii\web\Application($config);
$application->run();
