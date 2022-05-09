<?php

namespace common\components\general;

use Yii;
use yii\web\User;

class WebUser extends User
{
    const IDENTITY_ID_KEY = 'mainIdentityId';

    public function getIsImpersonated()
    {
        return !is_null(Yii::$app->session->get(self::IDENTITY_ID_KEY));
    }

    public function setMainIdentityId($userId)
    {
        Yii::$app->session->set(self::IDENTITY_ID_KEY, $userId);
    }

    public function getMainIdentityId()
    {
        $mainIdentityId = Yii::$app->session->get(self::IDENTITY_ID_KEY);
        return !empty($mainIdentityId) ? $mainIdentityId : $this->getId();
    }

 
}