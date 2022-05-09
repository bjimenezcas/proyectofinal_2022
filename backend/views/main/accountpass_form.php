<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php
$form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true
    , 'class' => 'form-control'
]);
?>
<div class="row">
    <div class="col col-12 col-md-12">

        <?= $form->field($model, "password")->input("password") ?>
        <?= $form->field($model, "password_repeat")->input("password") ?>

    </div>
    <div class="row">
        <div class="col-auto">
            <label class="form-label" > &nbsp; </label>
            <?=
            Html::submitButton(
                Yii::t('app', 'Update'), ['class' => 'col-md-3 form-control btn btn-primary'    ])
            ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

