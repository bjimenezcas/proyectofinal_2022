<?php

use yii\helpers\Url;
use common\components\general\ListOption;
use kartik\select2\Select2;
use kartik\dynagrid\DynaGrid;
use kartik\helpers\Html;
use common\components\general\Buttons;
use common\components\general\MyHelper;
use kartik\grid\GridView;


/* @var $searchModel common\models\boda\InvitacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = \Yii::t('app', 'Invitaciones');
$Breadcrumb[] = ['label' => \Yii::t('app', 'Invitaciones'), 'url' => ['index']];


$ListOptions = new ListOption();
$MyHelper = new MyHelper();

$Buttons = new Buttons();
$ButtonsExt = $Buttons->getButtons();
$ButtonsToolbar = $ButtonsExt->repeat . $ButtonsExt->create; // . $ButtonsExt->deleteall;


$Columns = ['id', 'confirmation', 'description', 'address', 'name', 'creation_date', 'baby', 'observation', 'order',];
$ConfigDynagrid = $Buttons->getConfigDynagrid($dataProvider, $searchModel, $Columns, $this->title);
$ButtonsTemplate = ' {open_form} {view} {update} {delete}';

$Orders = (new MyHelper())->getOrder(180);
?>
<?= $MyHelper->GenerateBreadcrum($Breadcrumb) ?>
<div class="invitaciones-index">


    <?= DynaGrid::widget(array_merge_recursive($ConfigDynagrid, [
        'gridOptions' => [
            'toolbar' => [
                [
                    'content' => $ButtonsToolbar
                ],
            ]
        ],

        'columns' => [

            [
                'class' => 'kartik\grid\ActionColumn',
                'mergeHeader' => true,
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to([$action, 'id' => $model->id]);
                },
                'header' => '',
                'template' => $ButtonsTemplate,
                'buttons' => ['clone' => function ($url, $model, $key) {
                    $Result = false;
                    $Result = Html::a(' <span class="fa fa-clone"></span>', $url, [
                        'title' => 'Clonar', 'target' => '', 'data-pjax' => '0',
                    ]);

                    return $Result;
                },'open_form' => function ($url, $model, $key) {
                    $Result = false;
                    $UrlWeb = Yii::$app->params['url_web'];
                    $Result = Html::a('<i class="far fa-arrow-alt-circle-right"></i>','', [
                    'title' => 'Abrir reserva','target'=>'_blank','onclick'=>'window.open("'.$UrlWeb.'reserva/crear?id='.$model->id.'")', 'class'=>'btn btn-success btn-sm',]);
            
                    return $Result;
                    }],
            ],
            'id',
            'name',
            'address',
            'baby',
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'confirmation',
                'vAlign' => 'middle',
                'trueLabel' => 'Si',
                'falseLabel' => 'No'
            ],
            [
                'attribute' => 'observation',
                'format' => 'raw',
                //'width' => '30px',
                'value' => function ($data) {
                    $result = $data->observation;
                    return MyHelper::truncateText($result, 50);
                },
            ],

            $MyHelper->DateRange("creation_date"),
            
        [
            'format' => 'raw',
            'width' => '50px',
            'attribute' => 'order',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => $Orders,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Orden'],
            'value' => function ($model, $key, $index, $widget) use ($Orders) {


                return Select2::widget([
                    'name' => 'sort',
                    'data' => $Orders,
                    'value' => $model->order,
                    'options' => [
                        //'class'=>'col-md-3',
                        'placeholder' => 'Selecciona el orden',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents' => [
                        "change" => "function(e) {
                       var select_val=$(this).val();                       
                        $.ajax({
                           type     :'post',
                           //dataType: 'html',
                           //async: true,
                           cache    : false,
                           url  : '" . Url::toRoute(['update_order', 'id' => $model->id]) . "&val='+select_val,
                           success  : function(response) {
                           //location.reload();
                           $.pjax.reload({container:'#kv-pjax-container-service'});
                           },
                           error: function() {
                               alert('Existen errores. No se puede realizar la acción.');
                           }
                           });
                        }"]
                ]);
            },
            'format' => 'raw'
        ],             
        [
            'attribute' => 'description',
            'format' => 'raw',
            //'width' => '30px',
            'value' => function ($data) {
                $result = $data->description;
                return MyHelper::truncateText($result, 50);
            },
        ],

        ],
    ])); ?>
</div>