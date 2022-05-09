<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use himiklab\yii2\recaptcha\ReCaptcha;

use common\components\general\MyHelper;
$MyHelper=new MyHelper();
?>

<div class="form-top">
    <div class="row text-center">
        <div class="col-md-12">
        <h2 class="d-none d-sm-block">Login</h2>
        </div>
    </div>
</div>
<div class="form-bottom">
    <div class="row title_login"></div>
    <?php
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'login-form'],
        'fieldConfig' => [
            'template' => "{input}\n{error}",
        ],
    ]);
    ?>
    <div class="form-group">
        <label for="user_label" class="user_label">Usuario o email</label>
        <?= $form->field($model, 'username')->textInput(['placeholder' => '']); ?>
    </div>
    <div class="form-group">
        <label for="pass_label" class="pass_label">Contraseña</label>
        <div id="showhide" onclick="ShowHide()" data-hide="no" class="show_hide" style=""><i class="far fa-eye"></i> Mostrar
        </div>
        <?php echo $form->field($model, 'password')->passwordInput(['placeholder' => '', 'id' => 'exampleInputPassword1']); ?>
    </div>
    <button type="submit" id="send_button" class="buton_submit btn btn-primary">Log In</button>
    <div class="col-12 text-center"><a href="<?= Url::toRoute(["recoverpass"]) ?>">Olvidaste la contraseña?</a>
    </div>
    <?php ActiveForm::end(); ?>
</div>