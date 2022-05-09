<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\components\general\ListOption;


$ListOptions = new ListOption();
/* @var $this yii\web\View */
/* @var $model common\models\boda\Invitados */
/* @var $form yii\widgets\ActiveForm */
$FishMeat = ['carne' => 'carne', 'pescado' => 'pescado'];
$TypeMenu = ['adulto' => 'adulto', 'niño' => 'niño'];
$Invitaciones = $ListOptions->getList(['type' => 'Invitaciones', 'id' => 'id', 'name' => 'name', 'cache' => false]);
?>

<div class="invitados-form panel-body">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-control']]); ?>

    <div class="row">
        <?= $form->field($model, 'name', ['options' => [
            'class' => 'col-md-2'
        ]])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surname', ['options' => [
            'class' => 'col-md-2'
        ]])->textInput(['maxlength' => true]) ?>


<?php
        echo $form->field($model, 'type_menu', ['options' => [
            'class' => 'col-md-2'
        ],], [
            'template' => "{label}\n\n{input}\n{hint}\n{error}",
        ])->widget(Select2::class, [
            'name' => 'type_menu',
            'data' => $TypeMenu,
            'options' => [
                'multiple' => false,
                'placeholder' => 'Selecciona el tipo de menu',
            ],
            'pluginOptions' => []
        ]); ?>
        <?php
        echo $form->field($model, 'id_invitacion', ['options' => [
            'class' => 'col-md-3'
        ],], [
            'template' => "{label}\n\n{input}\n{hint}\n{error}",
        ])->widget(Select2::class, [
            'name' => 'id_invitacion',
            'data' => $Invitaciones,
            'options' => [
                'multiple' => false,
                'placeholder' => 'Selecciona la invitacion',
            ],
            'pluginOptions' => []
        ]); ?>
        <?php
        echo $form->field($model, 'fish_or_meat', ['options' => [
            'class' => 'col-md-2'
        ],], [
            'template' => "{label}\n\n{input}\n{hint}\n{error}",
        ])->widget(Select2::class, [
            'name' => 'fish_or_meat',
            'data' => $FishMeat,
            'options' => [
                'multiple' => false,
                'placeholder' => 'Selecciona carne o pescado',
            ],
            'pluginOptions' => []
        ]); ?>

        <?= $form->field($model, 'order', ['options' => [
            'class' => 'col-md-1'
        ]])->textInput(['type' => 'number']) ?>
        <?= $form->field($model, 'bus', ['options' => [
            'class' => 'col-md-1 pt-4 pb-4'
        ]])->checkbox(); ?>
        <?= $form->field($model, 'allergens', ['options' => [
            'class' => 'col-md-1  pt-4 pb-4'
        ]])->checkbox(); ?>


<?= $form->field($model, 'confirmation', ['options' => [
            'class' => 'col-md-2  pt-4 pb-4'
        ]])->checkbox(); ?>
        <?= $form->field($model, 'finish', ['options' => [
                    'class' => 'col-md-2  pt-4 pb-4'
                ]])->checkbox(); ?>
        <?php
        echo $form->field($model, 'description', ['options' => [
            'class' => 'col-lg-12 '
        ],])->textarea()
        ?>
    </div>
    <div class="row">
        <div class="col-auto">
            <label class="form-label"> &nbsp; </label>
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')        : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success form-control' : 'btn
        btn-primary  form-control']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>