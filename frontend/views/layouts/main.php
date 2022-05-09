<?php

use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="es">

<head>
	<?php $this->head() ?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Boda Catalina & Marco 10-09-2022</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Página Web Boda" />

	<link rel="shortcut icon" href="<?= Url::to('@web/images/favicon.png') ?>">

	<link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Sacramento" rel="stylesheet">
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery-bundle.css'>
</head>

<body>
	<?php $this->beginBody() ?>
	<?= $content ?>

	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>