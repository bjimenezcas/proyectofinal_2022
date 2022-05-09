<?php

use yii\helpers\Url;

$Url = Url::toRoute('login/resetpass', 'https');
//$Url=Yii::$app->params["url"]."?r=login/resetpass";

$usuario = $model->username;

$Title = 'Boda restablecer contraseña';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Plantilla de correo</title>

    <base href="#">
</head>

<body>
    Hola <?= $usuario ?><br>
    ¿No recuerdas tu contraseña? Ningún problema, sigue el enlace a continuación
    y copia el siguiente código de verificación para restablecer una contraseña nueva.
    <p>Código:&nbsp;<strong><?= $verification_code ?></strong>
        Pulsa en la siguiente url para restablecer la contraseña <a target="_blank" href='<?= $Url ?>'>Restablecer contraseña</a>
</body>

</html>