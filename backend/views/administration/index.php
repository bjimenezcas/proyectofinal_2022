
<?php

use common\components\general\MyHelper;

$MyHelper=new MyHelper();
$Breadcrumb[] = ['label' => 'Administración '];

?>

<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>
<div class="px-4 py-5 my-5 text-center">
    <i class="fa fa-cogs fa-4x"></i>
    <h1 class="display-5 fw-bold">
        Panel de administración</></h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <colgroup>
                    <col class="col-xs-1">
                    <col class="col-xs-7">
                </colgroup>
                <thead>
                <tr>
                    <th>Parametro</th>
                    <th>Resultado</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row"><code>Titulo</code></th>
                    <td><?= Yii::$app->params['title'] ?></td>
                </tr>
                <tr>
                    <th scope="row"><code>Email</code></th>
                    <td><?= Yii::$app->params['adminEmail'] ?></td>
                </tr>
                <tr>
                    <th scope="row"><code>Versión</code></th>
                    <td><?= Yii::$app->session->get('version', '0.0.0'); ?></td>
                </tr>
                <tr>
                    <th scope="row"><code>Ip host</code></th>
                    <td><?= gethostbyname(gethostname()) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>