<?php

use common\components\general\MyHelper;

$MyHelper = new MyHelper();
$Breadcrumb[] = ['label' => 'Administración '];

?>

<?= $MyHelper->GenerateBreadcrum($Breadcrumb) ?>
<div class="px-4 py-5 text-center">
    <i class="fas fa-heart fa-4x"></i>
    <h1 class="display-5 fw-bold">
        Boda
    </h1>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Invitados</h5>
                <p class="card-text"> <span class="badge bg-warning "><?= $Invitados ?></span> invitados en total.</p>
                <p class="card-text"><span class="badge bg-success "><?= $Invitados_ok ?></span> asistiran y <span class="badge bg-danger "><?= $Invitados_ko ?></span> no asistiran.</p>
                <p class="card-text">Faltan <span class="badge bg-info "><?= $Invitados - ($Invitados_ok + $Invitados_ko) ?></span> invitados por confirmar.</p>
                <a href="<?= \yii\helpers\Url::to(['boda/invitados/index']) ?>" class="btn btn-primary">Ir a la tabla</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Invitaciones</h5>
                <p class="card-text"><span class="badge bg-warning "><?= $Invitaciones ?></span> invitaciones en total.</p>
                <p class="card-text"><span class="badge bg-success "><?= $Invitaciones_finish ?></span> finalizadas y <span class="badge bg-danger "><?= $Invitaciones - $Invitaciones_finish ?></span> faltan por finalizar.</p>
                <a href="<?= \yii\helpers\Url::to(['boda/invitaciones/index']) ?>" class="btn btn-secondary">Ir a la tabla</a>
            </div>
        </div>
    </div>
</div>