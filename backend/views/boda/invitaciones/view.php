<?php

use kartik\helpers\Html;
use common\components\general\Buttons;
use kartik\detail\DetailView;
use kartik\dynagrid\DynaGrid;
use common\components\general\MyHelper;
use common\models\boda\InvitadosSearch;
use Da\QrCode\QrCode;


$MyHelper = new MyHelper();

/* @var $this yii\web\View */
/* @var $model common\models\boda\Invitaciones */
$this->title = \Yii::t('app', 'Invitaciones');
$Breadcrumb[] = ['label' => \Yii::t('app', 'Invitaciones'), 'url' => ['index']];
$Breadcrumb[] = 'vista';
$ButtonsTemplate =  Html::a(\Yii::t('app', 'Update'),  ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
    $ButtonsTemplate .= Html::a(\Yii::t('app', 'Delete'),  ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]);
?>

<?= $MyHelper->GenerateBreadcrum($Breadcrumb) ?>
<div class="invitaciones-view">
    <div class="row">
        <div class="col-md-5">

            <?php $body = DetailView::widget([
                'model' => $model,
                'attributes' => [


                    'id',
                    'name',
                    [
                        'attribute' => 'confirmation',
                        'format' => 'raw',
                        'value' => $model->confirmation ?
                            '<span class="badge bg-success">Si</span>' :
                            '<span class="badge bg-danger">No</span>',
                        'type' => DetailView::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Si',
                                'offText' => 'No',
                            ]
                        ]
                    ],
                    'address',
                    'baby',
                    'description',
                    'observation',
                    'order',
                    'creation_date:datetime',
                ],
            ]) . $ButtonsTemplate ?>
            <?= Html::panel(
                ['heading' => '<i class="' . Yii::$app->session->get('glyphicons') . '"></i> ' . \Yii::t('app', 'Ver') . '
    ' . \Yii::t('app', 'Invitaciones'), 'body' => '
    <div class="panel-body">' . $body . '</div>
    ']
                //Html::TYPE_SUCCESS
            ); ?>
        </div>
        <div class="col-md-5 text-center">
            <?php 
            
$Buttons = new Buttons();
$ButtonsExt = $Buttons->getButtons();
$searchModel = new InvitadosSearch();
$searchModel->id_invitacion = $model->id;
$dataProvider = $searchModel->search($searchModel);
$Columns = ['id','name','surname',];
$ConfigDynagrid = $Buttons->getConfigDynagrid($dataProvider, $searchModel, $Columns, $this->title);
            ?>
    <?= DynaGrid::widget(array_merge_recursive($ConfigDynagrid, [
        'gridOptions' => [
            'toolbar' => [
                ['content' => ''
                ],
            ]
        ],
        'columns' => [
            'id', 
            'name',
            'surname',
            'type_menu'


        ],
    ])); ?>
        </div>
        <div class="col-md-2 text-center">
            <h3>Codigo qr</h3>
            <?php
            $qrCode = (new QrCode($UrlQr))
                ->setSize(250)
                ->setMargin(5);
            echo '<img src="' . $qrCode->writeDataUri() . '" class="img-fluid">';
            ?>

        </div>
    </div>
</div>