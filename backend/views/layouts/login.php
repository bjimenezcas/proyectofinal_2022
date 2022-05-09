<?php

use backend\assets\AppAssetLogin;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAssetLogin::register($this);
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
<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <div class="col-lg-4 mx-auto">
        <?= $content ?>

        <div class="row">

            <p style="" class="copyright"><span>&copy; <?php echo date("Y"); ?></span>
                    
                <span>Boda</span></p>

            </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
