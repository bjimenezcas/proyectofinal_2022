<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;

?>
<div class="row title_login"><h1>Reset password</h1></div>

<div class="form-bottom">
    <?php
    $form = ActiveForm::begin([
        'method' => 'post',
        'enableClientValidation' => true,
        'options' => ['class' => 'login-form'],
        'fieldConfig' => [
            'template' => "{input}\n{error}",
        ],
    ]);
    ?>

    <div class="form-group">
        <label for="email_label"  class="mail_label"><b>Email</b></label>
        <?= $form->field($model, "email")->textInput(array('placeholder' => '')); ?>
    </div>
    <div class="form-group">
        <label for="password"  class="password_label"><b>Contraseña</b></label>
        <?= $form->field($model, "password")->textInput(['placeholder' => '','type'=>'password']); ?>
    </div>
    <div class="form-group">
        <label for="password_repeat"  class="password_repeat_label"><b>Repite la contraseña</b></label>
        <?= $form->field($model, "password_repeat")->textInput(['placeholder' => '','type'=>'password']); ?>
    </div>
    <div class="form-group">
        <label for="verification_code"  class="verification_code_label"><b>Codigo de verificación</b></label>
        <?= $form->field($model, "verification_code")->textInput(array('placeholder' => '')); ?>
    </div>

    <button type="submit" id="send_button" name='login-button' class="buton_submit btn btn-primary">Reset Password
    </button>


    <?php ActiveForm::end(); ?>
</div>


<?=$this->render('parts/toast', ['msg' => $msg,]) ?>
