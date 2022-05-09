<?php

use common\components\general\MyHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\general\ListOption;

$ListOptions=new ListOption();
$MyHelper=new MyHelper();

$User=new \common\models\login\Users();
?>

<div class="config-transport-form panel-body">

    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-control']]); ?>
    <div class="row">

        <div class="col-md-12">
            <div class="row">
                <?=
                $form->field($model, 'username', ['options' => [
                    'class' => 'col-lg-6'],])->textInput(['maxlength' => true])
                ?>
                <?=
                $form->field($model, 'email', ['options' => [
                    'class' => 'col-lg-6'],])->textInput(['maxlength' => true])
                ?>
            </div>
            <div class="row">
                <?=
                $form->field($model, 'first_name', ['options' => [
                    'class' => 'col-lg-3'],])->textInput(['maxlength' => true])
                ?>
                <?=
                $form->field($model, 'last_name', ['options' => [
                    'class' => 'col-lg-3'],])->textInput(['maxlength' => true])
                ?>
    
                <?=
                $form->field($model, 'mobile', ['options' => [
                    'class' => 'col-lg-3'],])->textInput(['maxlength' => true])
                ?>
            </div>

            <div class="row">
                <?php //echo $form->field($model, 'password',['options'=>['class'=>'col-lg-6'],])->input('password') ?>
                <?php
                //echo $form->field($model, 'password_repeat',['options'=>[
                //'class'=>'col-lg-6'],])->input('password') 
                ?>
                <?php
                echo $form->field($model, 'description', ['options' => [
                    'class' => 'col-lg-12'],])->textarea()
                ?>
                <div class="col-md-3 col-md-offset-3">
                    <div class="form-group">
                        <label>&nbsp</label>
                        <?=
                        Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') :
                            Yii::t('app', 'Update'), ['class' => 'col-md-3 form-control ' . ($model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary')])
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>