<?php

use frontend\assets\AppAssetInvitacion;
use yii\helpers\Url;

AppAssetInvitacion::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="h-100">

<head>
	<?php $this->head() ?>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Boda Catalina & Marco 10-09-2022</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Página Web Boda" />
	<link rel="shortcut icon" href="<?= Url::to('@web/images/favicon.png') ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
	<style>
		@page {
			size: A5
		}
	</style>

</head>

<body class="A5">
	<?php $this->beginBody() ?>

	<div class="container-fluid" id="PricipalContainer">
		<?= $content ?>
	</div>

	<?php $this->endBody() ?>

</body>

</html>
<?php $this->endPage() ?>