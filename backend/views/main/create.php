<?php

use yii\helpers\Url;
use kartik\helpers\Html;
use common\components\general\MyHelper;
$MyHelper=new MyHelper();

$Breadcrumb[] = ['label' => 'Dashboard', 'url' => ['main/index']];
$Breadcrumb[] = ['label' => 'Creación',];
?>
<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>
<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <?= Html::img('@web/images/cont.png', ['style' => 'min-height:50px;height:50px;']); ?>
            <div class="caption">
                <h3>Conteos</h3>
                <p>Se pueden crear conteos de tablas para mostrar la información en el dashboard</p>
                <p><a href="<?= Url::to(['']) ?>" class="btn btn-primary" role="button">Crear</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <?= Html::img('@web/images/kpi.png', ['style' => 'min-height:50px;height:50px;']); ?>
            <div class="caption">
                <h3>Kpi</h3>
                <p>Se pueden crear estadisticas partiendo de los kpi, previamente generados</p>
                <p><a href="<?= Url::to(['']) ?>" class="btn btn-primary" role="button">Crear</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <?= Html::img('@web/images/info.png', ['style' => 'min-height:50px;height:50px;']); ?>
            <div class="caption">
                <h3>Informes</h3>
                <p>Se pueden visualizar informes, previamente configurados</p>
                <p><a href="<?= Url::to(['main/user_procedures/index']) ?>" class="btn btn-primary"
                      role="button">Crear</a>
            </div>
        </div>
    </div>
</div>