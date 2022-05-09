<?php


use common\components\general\MyHelper;

$MyHelper=new MyHelper();
$Breadcrumb[] = ['template' => '<i class="glyphicon glyphicon-user"></i> {link}</li>', 'label' => ' Mi cuenta',];
?>

<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>

<?php $body = $this->render('account_form', ['model' => $model,]); ?>


<div class="row row-cols-1 row-cols-md-12 mb-12 ">
    <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 fw-normal"><i class="fas fa-user-circle"></i> Datos de usuario</h4>
            </div>
            <div class="card-body">

<?=$body?>
            </div>
        </div>
    </div>
</div>

<?=$this->render('/login/parts/toast', ['msg' => $msg,]) ?>