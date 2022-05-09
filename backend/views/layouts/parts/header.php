<?php

use yii\helpers\Html;

$Url = \yii\helpers\Url::to('@web/images');
?>

    <meta charset="<?= Yii::$app->charset ?>">
	<link rel="shortcut icon" href="<?=$Url?>/favicon.png">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>