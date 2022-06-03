<?php

$Environment = $_SERVER["Environment"];//local,prod,dev
$Server = $_SERVER["Server"];//Local,Pro1,Pro2
$Params = [
    'server' => $Server,//Local,Pro1,Pro2
    'version' => 'v1.0',
    'title' => 'Boda',
    'web_login' => 'https://elgrandia.com/',
    //Dependencia de bootstrap de krajee
    'bsDependencyEnabled' => false,//true,false
    'enable_cache_menu' => false, //true,false

    //Version de BS de apps de krajee
    'bsVersion' => '5.x',//3.x,4.x

    //Hash de encriptación
    'hash_encrypt' => '89da4b727c12ddb6a55a0e174a0a408c',
];
if ($Environment == 'local') {
    $NewParams= [ /*Emails Pongo esto para machacar lo que hay en local*/
        'adminEmail' => 'jimenezcastrobeatriz@gmail.com',
        'EmailErrorAdmin' => ['jimenezcastrobeatriz@gmail.com'],
        'developmentEmail' => ['jimenezcastrobeatriz@gmail.com'],
        'enable_cache_menu' => true, //dev
    ];
}else{
    $NewParams= [
        'enable_cache_menu' => true, //prod
    ];
}
$Params = yii\helpers\ArrayHelper::merge($Params,$NewParams);
return $Params;