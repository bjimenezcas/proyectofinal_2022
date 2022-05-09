<?php

use yii\helpers\Html;
use common\components\general\MyHelper;
$MyHelper=new MyHelper();

$this->title = '';
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\LoginForm */
$Breadcrumb[] = $this->title;
?>

<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>
<div class="row " style="
     height: 100px;
     width: 100%;
     position: absolute;
     top: 40%;
     left: 0;
     margin-top: -50px; /* half the height of the element */">
    <div class="col-xs-offset-3 col-xs-6 ">
        <div style="/*background-color: rgb(95, 89, 81);*/" class="jumbotron">
            <h1><?= Html::encode($this->title) ?></h1>
            <h2><?php echo Html::img('@web/images/logo.png') ?></h2>
        </div>
    </div>
</div>