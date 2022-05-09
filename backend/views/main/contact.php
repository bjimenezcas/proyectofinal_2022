<?php

use common\components\general\MyHelper;

$this->title = '';
$MyHelper=new MyHelper();
$Breadcrumb[] = ['label' => 'Contacto',];
?>

<?= $MyHelper->GenerateBreadcrum($Breadcrumb)?>
<div class="col-lg-12">
    <div class="bs-callout bs-callout-danger" id="callout-navbar-fixed-top-padding">
        <h4>¿Necesitas ayuda?</h4>
        <p>Para cualquier problema relacionado con errores de desarrollo o de operativa, puedes escribir
            o contactar a las siguientes direcciones.</p>
        <br>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Contactos :</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Cargo</th>
                    <th>Area</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Jimenez Castro Beatriz</td>
                    <td>jimenezcastrobeatriz@gmail.com</td>
                    <td>6656666666</td>
                    <td>Developer</td>
                    <td>Tecnico</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>