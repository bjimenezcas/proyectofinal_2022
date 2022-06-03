<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use common\components\general\ListOption;

$ListOptions = new ListOption();

$Locations = [];
$VisitCustomer = [];

?>
<?php
$form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
    'class' => 'form-control'
]);
?>
<div class="row">
    <div class="col col-12 col-md-12">
        <?= $form->field($model, "id")->input("hidden")->label(false); ?>
        <div class="row">
            <?= $form->field($model, "username", ['options' => ['class' => 'col col-6']])->input("text")->textInput(['readonly' => true]); ?>
            <?= $form->field($model, "email", ['options' => ['class' => 'col col-6']])->input("text"); ?>
        </div>

        <div class="row">
            <?= $form->field($model, "first_name", ['options' => ['class' => 'col col-md-3']])->input("text"); ?>
            <?= $form->field($model, "last_name", ['options' => ['class' => 'col- col-md-3']])->input("text"); ?>
            <?= $form->field($model, "mobile", ['options' => ['class' => 'col col-md-3']])->input("text"); ?>
        </div>
        <div class="row">
            <div class="col-md-3 col-md-offset-3">
                    <label>&nbsp</label>
                    <?=
                    Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') :
                        Yii::t('app', 'Update'), ['class' => 'col-md-3 form-control ' . ($model->isNewRecord ? 'btn btn-success ' : 'btn btn-primary')])
                    ?>
            </div>

            <div class="col-md-3 offset-6">
                <label>&nbsp</label>
                    <a href="<?= Url::to(['main/accountpass']) ?>" type="button"
                       class="col-md-3 form-control  btn  btn-outline-secondary">Modificar contraseña</a>

            </div>
        </div>
    </div>
</div>
</div>
<?php ActiveForm::end(); ?>

