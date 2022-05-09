<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\general\ListOption;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\boda\Invitados;

/* @var $this yii\web\View */
/* @var $model common\models\boda\Invitaciones */
/* @var $form yii\widgets\ActiveForm */


$ListOptions = new ListOption();
$Id = $model->id;
$where = 'id_invitacion is null or id_invitacion="" ';
if ($type == 'update') {
    $where .= " or id_invitacion='" . $Id . "'";
}
$Query = Invitados::find()->where($where)->all();
$Invitados = ArrayHelper::map($Query, 'id', function (Invitados $model) {
    return "{$model->name} ({$model->surname})";
});
?>

<div class="invitaciones-form panel-body">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-control']]); ?>

    <div class="row">

        <?= $form->field($model, 'name', ['options' => [
            'class' => 'col-md-4'
        ]])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'address', ['options' => [
            'class' => 'col-md-4'
        ]])->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'confirmation', ['options' => [
            'class' => 'col-md-2  pt-4'
        ]])->checkbox(); ?>
        <?= $form->field($model, 'order', ['options' => [
            'class' => 'col-md-1'
        ]])->textInput(['type' => 'number']) ?>



        <?= $form->field($model, 'baby', ['options' => [
            'class' => 'col-md-1'
        ]])->textInput(['type' => 'number']) ?>


        <?php
        echo $form->field($model, 'invitados', ['options' => [
            'class' => 'col-md-10'
        ],], [
            'template' => "{label}\n\n{input}\n{hint}\n{error}",
        ])->widget(Select2::class, [
            'name' => 'invitados',
            'data' => $Invitados,
            'options' => [
                'multiple' => true,
                'placeholder' => 'Selecciona los invitados',
            ],
            'pluginOptions' => []
        ]); ?>
        <?php
        echo $form->field($model, 'creation_date', ['options' => [
            'class' => 'col-md-2'
        ],], [
            'template' => "{label}\n\n{input}\n{hint}\n{error}",
        ]); ?>

        <?php
        echo $form->field($model, 'observation', ['options' => [
            'class' => 'col-lg-12'
        ],])->textarea()
        ?>
        <?php
        echo $form->field($model, 'description', ['options' => [
            'class' => 'col-lg-12'
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