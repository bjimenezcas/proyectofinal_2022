<?php
use backend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
$Category = Yii::$app->session->get('category');
$SubCategory = Yii::$app->session->get('subcategory');
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->session->get('language') ?>" class="h-100">
    <head>
        <?= $this->render('parts/header') ?>
        <title><?= Yii::$app->params['title'] ?></title>
        <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <?php echo $this->render('parts/navbar', ['Category' => $Category, 'SubCategory' => $SubCategory]); ?>

    <div class="container-fluid" id="PricipalContainer">
            <?= $content ?>
    </div>
    <footer class="footer mt-auto py-2 bg-light">

        <div class="container" id="list_footer">
            <span class="text-muted align-bottom">Developed by <a style="color: #be882f" href="" target="_blank">Beatriz Jimenez</a></span>
            <div class="" style="float: right">

                <ul class="list-group list-group-horizontal ">
              
                <a class="list-group-item " href="<?= Url::toRoute('main/contact') ?>"><i class="fas fa-id-card-alt"></i> Contact</a>
                </ul>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
    
    </body>
    </html>
<?php $this->endPage() ?>