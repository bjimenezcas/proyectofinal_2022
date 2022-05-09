<?php

use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;

?>

<div class="row title_login"><h1>Recover password</h1></div>
<div class="form-bottom">
    <?php
    $form = ActiveForm::begin([
        'method' => 'post',
        'enableClientValidation' => true,
        'options' => ['class' => 'login-form'],
        'fieldConfig' => [
            'template' => "{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-4 control-label'],
        ],
    ]);
    ?>

    <div class="form-group">
        <label for="exampleInputEmail1"  class="mail_label"><b>Email</b></label>
        <?= $form->field($model, "email")->textInput(array('placeholder' => '')); ?>
    </div>
    <p>
        <a style=""" href="<?= Url::toRoute(["index"]) ?>">
            <i style="margin-right:5px;" class="far fa-arrow-alt-circle-left"></i>Back to login
        </a>
    </p>
    <button type="submit" id="send_button" name='login-button' class="buton_submit btn btn-primary">Recover Password
    </button>

    <?php ActiveForm::end(); ?>
</div>

<?=$this->render('parts/toast', ['msg' => $msg,]) ?>