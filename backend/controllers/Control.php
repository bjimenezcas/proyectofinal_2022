<?php

namespace backend\controllers;

use Yii;
use yii\web\HttpException;

class Control
{
    public function checkAcces()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        return true;
    }
    public function RedirectAccess()
    {
        Yii::$app->errorHandler->errorAction = '/login/lostsession';
        throw new HttpException(401, 'LostSession');
        //return $this->redirect(["login/lostsession"]);
    }
}
