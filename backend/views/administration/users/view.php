<?php

use kartik\helpers\Html;
use kartik\detail\DetailView;
use common\components\general\MyHelper;

$MyHelper=new MyHelper();
$this->title = '';

$Breadcrumb[] = ['label' => 'Administración ', 'url' => ['administration/index']];
$Breadcrumb[] = ['label' => 'Usuarios', 'url' => ['index']];
$Breadcrumb[] = 'Vista';
?>

<?=$MyHelper->GenerateBreadcrum($Breadcrumb)?>
<?php

$body = DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'first_name',
            'last_name',
            'mobile',
            'email',
            [
                'attribute' => 'enabled',
                'format' => 'raw',
                'value' => $model->enabled ?
                    '<span class="badge bg-success">Activo</span>':
                    '<span class="badge bg-danger">Inactivo</span>',
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Yes',
                        'offText' => 'No',
                    ]
                ]
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => $model->status ?
                '<span class="badge bg-success">Activo</span>' :
                        '<span class="badge bg-danger">Inactivo</span>',
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Yes',
                        'offText' => 'No',
                    ]
                ]
            ],
            'description',
            'created_at','updated_at'
        ],
    ]) .
    Html::a(\Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) .
    Html::a(\Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ])
?>
<?php

echo Html::panel(
    ['heading' => '<i class="' . Yii::$app->session->get('glyphicons') . '"></i> Ver usuario', 'body' => '<div class="panel-body">' . $body . '</div>']
//Html::TYPE_SUCCESS
);
?>
