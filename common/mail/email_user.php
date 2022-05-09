<?php

use yii\helpers\Url;

$id = urlencode($model->id);
$authKey = urlencode($model->auth_key);

$Url = Url::toRoute(['login/confirm', 'id' => $id, 'authKey' => $authKey], 'https');
$route = Url::toRoute('login/index', true);
$usuario = $model->email;

$Title = 'Boda Alta usuario';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Plantilla de correo</title>

    <base href="#">
</head>

<body>
    <h1> <?= $Title ?></h1>
    <h2>¡Usuario creado!</h2>
    Hola,<br>
    A continuación se adjuntan las credenciales de acceso:

    <strong>Usuario:</strong><?= $usuario ?>
    <strong>Password:</strong><?= $pass ?>
    Pulsa en la siguiente url para confirmar el usuario <a target="_blank" href='<?= $Url ?>'>Aqui</a>
</body>

</html>