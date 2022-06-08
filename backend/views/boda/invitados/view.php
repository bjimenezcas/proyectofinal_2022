<?php

use kartik\helpers\Html;
use kartik\detail\DetailView;
use common\components\general\MyHelper;

$MyHelper = new MyHelper();

/* @var $this yii\web\View */
/* @var $model common\models\boda\Invitados */
$this->title = \Yii::t('app', 'Invitados');
$Breadcrumb[] = ['label' => \Yii::t('app', 'Invitados'), 'url' => ['index']];
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
<div class="invitados-view">


    <?php $body = DetailView::widget([
        'model' => $model,
        'attributes' => [


            'id',
            'name',
            'surname',
            [
                'attribute' => 'confirmation',
                'format' => 'raw',
                'value' => $model->confirmation ?
                    '<span class="badge bg-success">Si</span>':
                    '<span class="badge bg-danger">No</span>',
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Si',
                        'offText' => 'No',
                    ]
                ]
            ],
            'gender',
            'fish_or_meat',
            'description',
            'order',
            [
                'attribute' => 'bus',
                'format' => 'raw',
                'value' => $model->bus ?
                    '<span class="badge bg-success">Si</span>':
                    '<span class="badge bg-danger">No</span>',
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Si',
                        'offText' => 'No',
                    ]
                ]
            ],
            [
                'attribute' => 'allergens',
                'format' => 'raw',
                'value' => $model->allergens ?
                    '<span class="badge bg-success">Si</span>':
                    '<span class="badge bg-danger">No</span>',
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Si',
                        'offText' => 'No',
                    ]
                ]
            ],        
            'type_menu',
            'id_invitacion',
            'finish',
            [
                'attribute' => 'finish',
                'format' => 'raw',
                'value' => $model->finish ?
                    '<span class="badge bg-success">Si</span>':
                    '<span class="badge bg-danger">No</span>',
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Si',
                        'offText' => 'No',
                    ]
                ]
            ],  
        ],
    ]) . $ButtonsTemplate ?>
    <?= Html::panel(
        ['heading' => '<i class="' . Yii::$app->session->get('glyphicons') . '"></i> ' . \Yii::t('app', 'Ver') . '
    ' . \Yii::t('app', 'Invitados'), 'body' => '
    <div class="panel-body">' . $body . '</div>
    ']
        //Html::TYPE_SUCCESS
    ); ?>

</div>