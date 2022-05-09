<?php

namespace common\models\login;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;
    public $reCaptcha;
    private $_user = false;
    public $Key;

    public function rules()
    {
        return [
            [['username', 'password', 'Key'], 'required', 'message' => 'Campo requerido'],
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            //[['reCaptcha'], ReCaptchaValidator::class, 'secret' => '6LfnbksUAAAAAL74kenKnwMWXKoWG-qn3wdgyV_n']
            [['Key'], 'integer'],
            [['Key'], 'string', 'min' => 6, 'max' => 6],
        ];
    }

    public function scenarios()
    {
        return [
            'normal' => ['username', 'password'],
        ];
    }


    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user) {
                try {
                    $Password = $this->password;
                    $ValidatePassword = $user->validatePassword($Password, $user);
                    if (!$ValidatePassword) {
                        $this->addError($attribute, 'Incorrect username or password.');
                    }
                } catch (Exception $exception) {
                    $this->addError($attribute, 'Ha ocurrido un problema al iniciar tu cuenta, por favor inténtalo más tarde.');
                }
            } else {

                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);
            return false;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Users::findByUsername($this->username, 1);
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'reCaptcha' => 'Captcha',
            'Key' => Yii::t('app', 'Key'),
        ];
    }

}
