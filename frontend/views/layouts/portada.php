<?php

use frontend\assets\AppAssetPortada;
use yii\helpers\Url;

AppAssetPortada::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="">

<head>	
<?= $this->render('parts/header') ?>
</head>
<?php $this->beginBody() ?>
<div>
	<?= $content ?>
</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>