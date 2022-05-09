<?php

namespace common\models\login;

use Yii;
use yii\db\ActiveRecord;
use Skilla\ValidatorCifNifNie\Validator;
use Skilla\ValidatorCifNifNie\Generator;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class Users extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'web_users';
    }

    public $password_repeat;
    public $password;
    public $UserPrivileges;

    public function scenarios()
    {
        return [
            'update' => ['id', 'username', 'email', 'enabled', 'password', 'password_repeat', 'first_name', 'last_name', 'mobile', 'description', 'updated_at'
            ],
            'register' => [
                 'username', 'email', /* 'password','password_repeat', */ 'first_name', 'last_name', 'mobile', 'description',  'description', 'language', 'app', 'created_at',
            ],
            'account' => ['username', 'email', 'avatar', 'first_name', 'last_name', 'mobile', 'updated_at', 'dni'],
            'accountpass' => ['password_hash', 'updated_at', 'password_hash', 'auth_key'],
            'confirm' => ['enabled'],
            'verification' => ['verification_code'],
            'reset_pass' => ['email', 'password', 'password_repeat', 'verification_code', 'enabled', 'auth_key'],
            'save_reset_pass' => ['email', 'password', 'verification_code', 'enabled', 'auth_key'],
            'recover_pass' => ['email'],
            'status' => ['status'],
        ];
    }

    public function rules()
    {
        return [
            [['enabled'], 'integer'],
            [['created_at',], 'safe'],
            [['id', 'user_name', 'email', 'auth_key', 'password_hash', 'password', 'confirmation_token', 'description'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'mobile'], 'string', 'max' => 64],
            [['access_token', 'verification_code'], 'string', 'max' => 250],
            [['enabled'], 'integer', 'on' => ['update']],
            [['username', 'email', 'password_hash', 'password', 'password_repeat', 'app'], 'required', 'message' => 'Campo requerido', 'on' => 'register'],
            [['username', 'email'], 'required', 'message' => 'Campo requerido', 'on' => 'account'],
            [['password_hash', 'password', 'password_repeat'], 'required', 'message' => 'Campo requerido', 'on' => 'accountpass'],
            [['id', 'username', 'email'], 'required', 'message' => 'Campo requerido', 'on' => 'update'],
            ['username', 'match', 'pattern' => "/^.{3,50}$/", 'message' => 'Mínimo 3 y máximo 50 caracteres', 'on' => ['update', 'register', 'account']],
            ['username', 'match', 'pattern' => "/^[0-9a-z_]+$/i", 'message' => 'Sólo se aceptan letras y números', 'on' => ['update', 'register', 'account']],
            ['username', 'username_existe', 'on' => ['register', 'update', 'account']],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres', 'on' => ['update', 'register', 'account', 'recover_pass']],
            ['email', 'email', 'message' => 'Formato no válido', 'on' => ['update', 'register', 'account', 'reset_pass', 'recover_pass']],
            ['email', 'email_existe', 'on' => ['register', 'update']],
            ['password_hash', 'match', 'pattern' => "/^.{6,100}$/", 'message' => 'Mínimo 6 y máximo 100 caracteres', 'on' => ['register', 'accountpass', 'update', 'reset_pass']],

            [['password', 'password_repeat'], 'match', 'pattern' => "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", 'message' => 'Mínimo 8 caracteres y al menos 1 letra y 1 numero.', 'on' => ['register', 'accountpass', 'update', 'reset_pass']],
            [
                'password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Los passwords no coinciden', 'on' => ['reset_pass', 'register', 'accountpass', 'update'],
            ],
            [['email', 'password_hash', 'password_repeat', 'verification_code'], 'required', 'message' => 'Campo requerido', 'on' => ['reset_pass']],
            [['email'], 'required', 'message' => 'Campo requerido', 'on' => ['recover_pass']],
        ];
    }



    public function email_existe($attribute, $params)
    {
        $user = Users::find()->where(['id' => $this->id, 'email' => $this->email])->one();

        if ($user) {

            if ($this->id && $this->email == $user->email) {
            } else {
                $this->addError($attribute, "El email seleccionado existe");
            }
        }
    }
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }



    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

        return static::findOne(['access_token' => $token]);
        //return static::findOne();
    }
    public function username_existe($attribute, $params)
    {

        $user = Users::find()->where(['id' => $this->id, 'username' => $this->username])->one();

        if ($user) {
            if ($this->id && $user && $this->username == $user->username) {
            } else {

                $this->addError($attribute, "El usuario seleccionado existe");
            }
        }
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public static function findByUsername($username, $app)
    {

        $UserName = explode('@', $username);
        $UserName = $UserName[0];
        $Query = static::find()->where(['username' => $UserName, 'status' => self::STATUS_ACTIVE])->one();
        if (!$Query) {
            $Query = static::find()->where(['email' => $username, 'status' => self::STATUS_ACTIVE])->one();
        }
        return $Query;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password, $user = null)
    {
        $Password = false;
        if ($this->password_hash) {
            Yii::warning("password_hash");
            $Password = Yii::$app->security->validatePassword($password, $this->password_hash);
        }
        return $Password;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('app', 'Nombre de usuario'),
            'email' => 'Email',
            'enabled' => Yii::t('app', 'Activo'),
            'auth_key' => 'auth_key',
            'password_hash' => Yii::t('app', 'Contraseña'),
            'confirmation_token' => Yii::t('app', 'Token de confirmación'),
            'first_name' => Yii::t('app', 'Nombre'),
            'last_name' => Yii::t('app', 'Apellidos'),
            'mobile' => Yii::t('app', 'Movil'),
            'access_token' => Yii::t('app', 'Token de acceso'),
            'verification_code' => Yii::t('app', 'Verification Code'),
            'status' => Yii::t('app', 'Estado'),
            'description' => Yii::t('app', 'Descripcion'),
            'created_at' => Yii::t('app', 'Creación'),
            'updated_at' => Yii::t('app', 'Actualización'),
        ];
    }
}
