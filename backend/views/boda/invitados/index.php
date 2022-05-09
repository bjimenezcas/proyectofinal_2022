<?php
use yii\helpers\Url;
use common\components\general\ListOption;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\dynagrid\DynaGrid;
use kartik\helpers\Html;
use common\components\general\Buttons;
use common\components\general\MyHelper;


/* @var $searchModel common\models\boda\InvitadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = \Yii::t('app','Invitados');
$Breadcrumb[] = ['label' => \Yii::t('app','Invitados'), 'url' => ['index']];


$ListOptions=new ListOption();
$MyHelper=new MyHelper();

$Buttons=new Buttons();
$ButtonsExt = $Buttons->getButtons();
$ButtonsToolbar =$ButtonsExt->repeat.$ButtonsExt->create  ;// . $ButtonsExt->deleteall;


$Columns=['id','name','surname','confirmation','fish_or_meat','description','order','bus','allergens','type_menu','id_invitacion','table','finish'];
$ConfigDynagrid = $Buttons->getConfigDynagrid($dataProvider,$searchModel,$Columns,$this->title);
    $ButtonsTemplate = '{view} {update} {delete}';

    $Orders = $MyHelper->getOrder(180);

    $Invitaciones = $ListOptions->getList(['type' => 'Invitaciones', 'id' => 'id', 'name' => 'name', 'cache' => false]);
    $TypeMenu=['adulto'=>'adulto','niño'=>'niño'];
    $Gender=['hombre'=>'hombre','mujer'=>'mujer'];
    $Table=['mesa_1'=>'Mesa 1','mesa_2'=>'Mesa 2','mesa_3'=>'Mesa 3','mesa_4'=>'Mesa 4','mesa_5'=>'Mesa 5','mesa_6'=>'Mesa 6','mesa_7'=>'Mesa 7','mesa_8'=>'Mesa 8','mesa_9'=>'Mesa 9','mesa_10'=>'Mesa 10','mesa_11'=>'Mesa 11','mesa_12'=>'Mesa 12','mesa_13'=>'Mesa 13','mesa_14'=>'Mesa 14','mesa_15'=>'Mesa 15','mesa_16'=>'Mesa 16','mesa_17'=>'Mesa 17','mesa_18'=>'Mesa 18','mesa_19'=>'Mesa 19','mesa_20'=>'Mesa 20',];
 ?> 
<?= $MyHelper->GenerateBreadcrum($Breadcrumb)?>
<div class="invitados-index">


            <?=         DynaGrid::widget(array_merge_recursive($ConfigDynagrid,[
        'gridOptions'=>[
        'toolbar' => [
        ['content' => $ButtonsToolbar
        ],
        ]
        ],

        'columns' => [

        ['class' => 'kartik\grid\ActionColumn',
        'mergeHeader' => true,
        'urlCreator' => function ($action, $model, $key, $index) {
        return Url::to([$action, 'id' => $model->id]);
        },
        'header' => '',
        'template' => $ButtonsTemplate,
        'buttons' => ['clone' => function ($url, $model, $key) {
        $Result = false;
        $Result = Html::a(' <span class="fa fa-clone"></span>', $url, [
        'title' => 'Clonar', 'target' => '', 'data-pjax' => '0',]);

        return $Result;
        }],
        ],
                    'id',
            'name',
            'surname',
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'confirmation',
                'vAlign' => 'middle',
                'trueLabel' => 'Si',
                'falseLabel' => 'No'
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'finish',
                'vAlign' => 'middle',
                'trueLabel' => 'Si',
                'falseLabel' => 'No'
            ],
            'fish_or_meat',
            
        
        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'bus',
            'vAlign' => 'middle',
            'trueLabel' => 'Si',
            'falseLabel' => 'No'
        ],
        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'allergens',
            'vAlign' => 'middle',
            'trueLabel' => 'Si',
            'falseLabel' => 'No'
        ],
        [
            'format' => 'raw',
            'width' => '50px',
            'attribute' => 'table',                
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => $Table,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Mesa'],
            'value' => function ($model) use ($Table) {


                return Select2::widget([
                    'name' => 'table',
                    'data' => $Table,
                    'value' => $model->table,
                    'options' => [
                        //'class'=>'col-md-3',
                        'placeholder' => 'Selecciona la mesa',
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
                           url  : '" . Url::toRoute(['update_table', 'id' => $model->id]) . "&val='+select_val,
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
            'format' => 'raw',
            'width' => '50px',
            'attribute' => 'gender',                
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => $Gender,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Genero'],
            'value' => function ($model, $key, $index, $widget) use ($Gender) {


                return Select2::widget([
                    'name' => 'gender',
                    'data' => $Gender,
                    'value' => $model->gender,
                    'options' => [
                        //'class'=>'col-md-3',
                        'placeholder' => 'Selecciona el genero',
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
                           url  : '" . Url::toRoute(['update_gender', 'id' => $model->id]) . "&val='+select_val,
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
            'format' => 'raw',
            'width' => '50px',
            'attribute' => 'type_menu',                
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => $TypeMenu,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Tipo menu'],
            'value' => function ($model, $key, $index, $widget) use ($TypeMenu) {


                return Select2::widget([
                    'name' => 'type_menu',
                    'data' => $TypeMenu,
                    'value' => $model->type_menu,
                    'options' => [
                        //'class'=>'col-md-3',
                        'placeholder' => 'Selecciona el tipo de menu',
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
                           url  : '" . Url::toRoute(['update_type_menu', 'id' => $model->id]) . "&val='+select_val,
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
                'format' => 'raw',
                'width' => '50px',
                'attribute' => 'id_invitacion',
                
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $Invitaciones,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Invitaciones'],
                'value' => function ($model, $key, $index, $widget) use ($Invitaciones) {
    
    
                    return Select2::widget([
                        'name' => 'id_invitacion',
                        'data' => $Invitaciones,
                        'value' => $model->id_invitacion,
                        'options' => [
                            //'class'=>'col-md-3',
                            'placeholder' => 'Selecciona la invitacion',
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
                               url  : '" . Url::toRoute(['update_invitacion', 'id' => $model->id]) . "&val='+select_val,
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
