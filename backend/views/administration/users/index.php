<?php

use yii\helpers\Url;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\helpers\Html;
use common\components\general\Buttons;
use kartik\checkbox\CheckboxX;
use common\components\general\ListOption;
use common\components\general\MyHelper;

$ButtonsExt = (new Buttons())->getButtons();

$MyHelper=new MyHelper();
$ListOptions = new ListOption();

$this->title = 'Usuarios';

$Breadcrumb[] = ['label' => 'Administración ', 'url' => ['administration/index']];
$Breadcrumb[] = ['label' => 'Usuarios',];
$Columns = ['id', 'username', 'first_name', 'last_name', 'mobile', 'email', 'enabled', 'status', 'description', 'created_at', 'updated_at',];
$ConfigDynagrid = (new Buttons())->getConfigDynagrid($dataProvider, $searchModel, $Columns, $this->title);
$User=new \common\models\login\Users();
?>
<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>

<?php
echo DynaGrid::widget(array_merge_recursive($ConfigDynagrid, [
    'columns' =>
        [['class' => 'kartik\grid\ActionColumn',
            'mergeHeader' => true,
            'header' => '',
            'vAlign' => 'middle',
            'template' => '{view} {update} {delete} {send}',
            'buttons' =>
                [
                    'delete' => function ($url, $model, $key) {
                        return Html::a(' <span '
                            . 'class="fa fa-trash"></span>', Url::to(['delete', 'id' => $model->id,
                            'page' => isset($_GET["page"]) ? $_GET["page"] : 0]), ['data' => [
                            'confirm' => 'Estas seguro de eliminar este usuario ?',
                            'method' => 'post',
                        ],
                            'title' => Yii::t('app', 'delete')]);
                    }, ],],
            'id',
        
            'username',
            'first_name',
            'last_name',
            'mobile',
            'email',
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'enabled',
                'vAlign' => 'middle',
                'trueLabel' => 'Activo',
                'falseLabel' => 'Inactivo'
            ], [
            'attribute' => 'status', 'format' => 'raw',
            'value' => function ($data) {
                return CheckboxX::widget([
                    'name' => 'check_' . $data->id,
                    'id' => 'check_' . $data->id,
                    'value' => $data->status,
                    'readonly' => false,
                    'pluginOptions' => ['threeState' => false,
                        'iconChecked' => '<i class="fas fa-check" style="color:green"></i>',
                    ],
                    'pluginEvents' => [
                        "change" => "function(e,t) {  $.ajax({
                              
                        url:'" . Url::toRoute(['updateestado']) . "',
                        type: 'post',
                        data: {id:'" . $data->id . "'},
                        dataType: 'html',
                    });}",
                    ]
                ]);
            }, 'filterType' => GridView::FILTER_CHECKBOX_X,
            'filterWidgetOptions' => [
                'pluginOptions' => ['threeState' => false,
                    'iconChecked' => '<i class="fas fa-check" style="color:green"></i>',
                ],
            ],
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

            $MyHelper->DateRange('created_at'),
            $MyHelper->DateRange('updated_at'),
        ],
    'gridOptions' => [
        'toolbar' => [
            ['content' => $ButtonsExt->create . $ButtonsExt->repeat
            ],
        ]
    ]
]));
?>
