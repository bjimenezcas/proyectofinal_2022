<?php
use kartik\helpers\Html;
use common\components\general\MyHelper;

$MyHelper=new MyHelper();


/* @var $this yii\web\View */
/* @var $model common\models\boda\Invitados */

$this->title =\Yii::t('app','Create').' '. \Yii::t('app','Invitados');

$Breadcrumb[] = ['label' => \Yii::t('app','Invitados'), 'url' => ['index']];
$Breadcrumb[] = $this->title;
?>

<?= $MyHelper->GenerateBreadcrum($Breadcrumb)?>
<div class="invitados-create">

    <?php $body=$this->render('_form', ['model' => $model,]); ?>

    <?= Html::panel(
    ['heading' => '<i class="'.Yii::$app->session->get('glyphicons').'"></i> '.$this->title, 'body' => $body]
    //Html::TYPE_SUCCESS
    );?>

</div>
