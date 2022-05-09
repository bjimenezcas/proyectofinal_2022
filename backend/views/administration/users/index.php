<?php

use yii\helpers\Url;
use yii\bootstrap5\Modal;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\helpers\Html;
use common\components\general\Buttons;
use kartik\checkbox\CheckboxX;
use kartik\widgets\Spinner;
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
                    }, 
                    'send' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-paper-plane"></i>', false, [
                        'data-pjax' => 0,
                        'class' => '',
                        'title' => 'send email',
                        'onclick' => "CheckSend(" . $model->id . ")",
                    ]);
                }],],
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

$Spinner = "<div class=''>" . Spinner::widget(['preset' => 'large', 'align' => 'center']) . '<div class="clearfix"></div></div>';
Modal::begin([
    'id' => 'ModalSend',
    // 'name'=>'ModalClose',
    'title' => '<p>¿Estás seguro de reenviar el correo de confirmación?</p>',
    'footer' => Html::a('<i class="fa fa-times"></i> Cerrar ', false, [
            'class' => 'btn btn-danger',
            'title' => 'Cerrar',
            'data-target' => "#ModalSend",
            'data-toggle' => "modal",
        ]) . Html::a('<i class="fa fa-check"></i> Proceder ', false, [
            'class' => 'btn btn-primary',
            'title' => 'contiunar',
            'id' => "proced_send_email",
        ]),
]);
echo '<div id="body_modal">Este proceso desactivara el usuario y le enviara una nueva password para que active la cuenta mediante el enlace que se le envía por correo electronico.<br>(Generara un nuevo token y una nueva clave de acceso) </div>';

echo '<div style="display:none" id="body_loading">Espere por favor.....' . $Spinner . '</div><div id="body_modal"></div>';
Modal::end();
?>

<script>
    function CheckSend(i) {
        $('#ModalSend').modal('show');
        $('#proced_send_email').attr('onclick', 'Send(' + i + ')');
    }
    ;

    function Send(i) {

        $('#body_modal').html('');
        $('#body_loading').css('display', 'block');
        $.ajax({
            url: '<?= Url::toRoute(['administration/users/send_confirm']) ?>?id=' + i + '',
            type: 'post',
            dataType: 'html',
            success: function (data) {
                var data = JSON.parse(data);
                location.reload();
            },
            error: function () {
                alert('An error has occured .');
            }
        });
    }
    ;
</script>