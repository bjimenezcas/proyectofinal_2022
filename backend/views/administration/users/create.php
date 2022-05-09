<?php

use common\components\general\MyHelper;
use kartik\helpers\Html;
$MyHelper=new MyHelper();
$this->title = '';


$Breadcrumb[] = ['label' => 'Administración ', 'url' => ['administration/index']];
$Breadcrumb[] = ['label' => 'Usuarios ', 'url' => ['index']];
$Breadcrumb[] = 'Crear';
?>

<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>
<?php $body = $this->render('_form', ['model' => $model,]) ?>
<?php

echo Html::panel(
    ['heading' => '<i class="glyphicon glyphicon-user"></i> Crear usuario', 'body' => $body]
);
?>