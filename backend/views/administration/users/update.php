<?php

use common\components\general\MyHelper;
use kartik\helpers\Html;
$this->title = '';

$MyHelper=new MyHelper();

$Breadcrumb[] = ['label' => 'Administración ', 'url' => ['administration/index']];
$Breadcrumb[] = ['label' => 'Usuarios', 'url' => ['index']];
$Breadcrumb[] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$Breadcrumb[] = 'Actualizar';
?>

<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>
<?php $body = $this->render('_form', ['model' => $model,]) ?>
<?php

echo Html::panel(
    ['heading' => '<i class="glyphicon glyphicon-user"></i> Actualizar usuario', 'body' => $body]
//Html::TYPE_SUCCESS
);
?>