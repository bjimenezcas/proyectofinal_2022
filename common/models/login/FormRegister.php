<?php

namespace common\models\login;

use Yii;
use yii\base\Model;

class FormRegister extends Model
{

    public $id;
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $new_password;
    public $enabled;

    public function scenarios()
    {
        return [
            'update' => ['id', 'username', 'email', 'enabled', 'password'],
            'register' => ['username', 'email', 'password', 'password_repeat'],
            'account' => ['username', 'email'],
            'accountpass' => ['password', 'password_repeat'],
            'relaciones' => ['id', 'username'],
        ];
    }

    public function rules()
    {
        return [
            [['id', 'enabled'], 'integer', 'on' => ['update']],
            [['username', 'email', 'password', 'password_repeat'], 'required', 'message' => 'Campo requerido', 'on' => 'register'],
            [['username', 'email'], 'required', 'message' => 'Campo requerido', 'on' => 'account'],
            [['password', 'password_repeat'], 'required', 'message' => 'Campo requerido', 'on' => 'accountpass'],
            //[['username', 'email','new_password', 'password', 'password_repeat'], 'required', 'message' => 'Campo requerido', 'on' => 'account'],
            [['id', 'username', 'email'], 'required', 'message' => 'Campo requerido', 'on' => 'update'],
            ['username', 'match', 'pattern' => "/^.{3,50}$/", 'message' => 'Mínimo 3 y máximo 50 caracteres', 'on' => ['update', 'register', 'account']],
            ['username', 'match', 'pattern' => "/^[0-9a-z]+$/i", 'message' => 'Sólo se aceptan letras y números', 'on' => ['update', 'register', 'account']],
            ['username', 'username_existe', 'on' => 'register'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres', 'on' => ['update', 'register', 'account']],
            ['email', 'email', 'message' => 'Formato no válido', 'on' => ['update', 'register', 'account']],
            ['email', 'email_existe', 'on' => 'register'],

            [['password','password_repeat'], 'match', 'pattern' => "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", 'message' => 'Mínimo 8 caracteres y al menos 1 letra y 1 numero.', 'on' => ['register', 'accountpass']],

            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Los passwords no coinciden', 'on' => ['register', 'accountpass']],
            //['id', 'integer', 'on' => 'update'],
        ];
    }

    public function email_existe($attribute, $params)
    {

        //Buscar el email en la tabla
        $table = Users::find()->where("email=:email", [":email" => $this->email]);

        //Si el email existe mostrar el error
        if ($table->count() == 1) {
            $this->addError($attribute, "El email seleccionado existe");
        }
    }

    public function username_existe($attribute, $params)
    {
        //Buscar el username en la tabla
        $table = Users::find()->where("username=:username", [":username" => $this->username]);

        //Si el username existe mostrar el error
        if ($table->count() == 1) {
            $this->addError($attribute, "El usuario seleccionado existe");
        }
    }

}
