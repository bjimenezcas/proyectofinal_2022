<?php

use kartik\helpers\Html;
use common\components\general\MyHelper;

$MyHelper=new MyHelper();

/* @var $this yii\web\View */
/* @var $model common\models\boda\Invitaciones */

$this->title =\Yii::t('app','Update').' '. \Yii::t('app','Invitaciones');
$Breadcrumb[] = ['label' => \Yii::t('app','Invitaciones'), 'url' => ['index']];

$Breadcrumb[] = Yii::t('app', 'Update');
?>

<?= $MyHelper->GenerateBreadcrum($Breadcrumb)?>
<div class="invitaciones-update">
    <?php $body=$this->render('_form', ['model' => $model,'type'=>'update']); ?>

    <?= Html::panel(
    ['heading' =>'<i class="'.Yii::$app->session->get('glyphicons').'"></i> '. $this->title, 'body' => $body]
    //Html::TYPE_SUCCESS
    );?>
</div>
