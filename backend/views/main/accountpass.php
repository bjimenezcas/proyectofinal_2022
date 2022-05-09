<?php
use common\components\general\MyHelper;
$MyHelper=new MyHelper();

$Breadcrumb[] = ['label' => ' Mi cuenta', 'url' => ['account']];
$Breadcrumb[] = 'Modificar contraseña';
?>

<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>
<?php
$body = $this->render('accountpass_form', ['model' => $model,]); ?>
            <div class="row row-cols-1 row-cols-md-12 mb-12 ">
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Modificar contraseña</h4>
                        </div>
                        <div class="card-body">

                            <?= $body ?>
                        </div>
                    </div>
                </div>
            </div>

<?=$this->render('/login/parts/toast', ['msg' => $msg,]) ?>