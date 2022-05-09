<?php

use backend\assets\AppAssetEmpty;

/* @var $this \yii\web\View */
/* @var $content string */

$this->render('parts/environment');
AppAssetEmpty::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= $this->render('parts/header') ?>
    <title><?= Yii::$app->params['title'] ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
