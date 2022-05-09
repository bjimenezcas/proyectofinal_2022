<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\login\LoginForm;
use common\components\general\MyHelper;
use common\models\login\Users;

class LoginController extends Controller
{


    public function actions()
        
    {
        $this->layout = 'login';

        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {

        $model = new LoginForm();
        $model->scenario = 'normal';
        if (!\Yii::$app->user->isGuest) {
            $Enabled = Yii::$app->session->get('credentials');
            return $this->AccesCorrect($model);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                    $model->login();
                    Yii::$app->session->set('credentials', 0);

                return $this->AccesCorrect($model);
            } else {

                LoginController::CheckReferrer();
                return $this->render('index', [
                    'model' => $model,
                ]);


            }
        }
        /**/
    }

    public function CheckReferrer()
    {
        $Referrer = Yii::$app->request->referrer;
        $Find = 'multichannel.wizinkservice.com/panel';
        if (strpos($Referrer, $Find)) {
            Yii::$app->session->Set('Referrer', $Referrer);
        }

    }

    public function AccesCorrect($model)
    {
        $this->layout = 'login';
        $model->login();
        $Referrer = Yii::$app->session->get('Referrer',false);

        if ($Referrer) {
            Yii::warning("Referrer ->" . $Referrer);
            Yii::$app->session->remove('Referrer');
        }

        return $this->render('accescorrect', ['Referrer' => $Referrer]);
    }

    public function actionConfirm()
    {
        if (Yii::$app->request->get()) {
            $id = Html::encode($_GET["id"]);
            $authKey = $_GET["authKey"];

            if ($id && $authKey) {

                $model = Users::find()
                    ->where(['and', ["id" => $id]])->one();

                $AuthValidate = $model->validateAuthKey($authKey);
                if ($model) {
                    $model->scenario = 'confirm';
                    $model->enabled = 1;
                    Yii::$app->user->logout();
                    if ($model->save()) {

                        return $this->render("confirm");
                    } else {
                        return $this->render("error");
                    }
                } else { //Si no existe redireccionamos a login
                    return $this->redirect(["login/index"]);
                }
            } else { //Si id no es un número entero redireccionamos a login
                return $this->redirect(["login/index"]);
            }
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionDeny()
    {
        $this->layout = 'login';
        return $this->render('deny');
    }

    public function actionProhibido()
    {
        $this->layout = 'login';
        return $this->render('prohibido');
    }

    public function actionLostsession()
    {

        Yii::warning("Lost Session->");
        return $this->render('lostsession');
    }

    public function actionError()
    {
        $this->layout = 'login';
        return $this->render('404');
    }

    public function actionMaintenance()
    {
        return $this->render('maintenance');
    }

    public function actionRecoverpass()
    {
        $model = new Users();
        $model->scenario = 'recover_pass';
        $msg = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = Users::find()->where(['email' => $model->email])->one();
                if ($table) {
                        $verification_code = MyHelper::randKey("abcdef0123456789", 8);
                        $table->verification_code = $verification_code;
                        $table->scenario = 'verification';
                        if ($table->validate()) {
                            $table->save();
                        } else {
                            Yii::error("Error model ->" . json_encode($table->getErrors()));
                        }

                        $subject = "Recuperar contraseña";
                        $content = Yii::$app->controller->renderPartial
                        ('@common/mail/email_lost', ['verification_code' => $verification_code, 'model' => $table]);

                        Yii::$app->mailer->compose()
                            ->setTo($model->email)
                            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                            ->setSubject($subject)
                            ->setHtmlBody($content)
                            ->send();
                        $model->email = null;

                        $title = 'Correcto!';
                        $type = '#06d6a0';
                        $msgBody = "Le hemos enviado un mensaje a su cuenta de "
                            . "correo para que pueda resetear su contraseña";
                        $timer = 20000;

                } else { //El usuario no existe
                    $title = 'Error!';
                    $type ='#ef476f' ;
                    $msgBody = 'No existe el email.';
                    $timer = 2000;
                }

                $msg =(object) [
                    'type' => $type,
                    'title' => $title,
                    'body' => $msgBody,
                    'timer' => $timer,
                ];
            } else {
                $model->getErrors();
            }
        }

        return $this->render("recoverpass", ["model" => $model, "msg" => $msg]);
    }

    public function actionResetpass()
    {
        $model = new Users();
        $model->scenario = 'reset_pass';
        $msg = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = Users::findOne(["email" => $model->email,
                    "verification_code" => $model->verification_code]);
                if (empty($table)) {
                    $title = 'Error!';
                    $type = '#ef476f';
                    $msgBody = 'Los datos no son correctos, no ha podido restablecerse la contraseña.';
                    $timer = 10000;
                } else {
                    //Encriptar el password
                    $table->setPassword($model->password);
                    $table->enabled = 1;
                    $table->generateAuthKey();

                    $table->scenario = 'save_reset_pass';
                    //Si la actualización se lleva a cabo correctamente
                    if ($table->save()) {

                        //Vaciar los campos del formulario
                        $model->email = null;
                        $model->password = null;
                        $model->password_repeat = null;
                        $model->verification_code = null;
                        $title = 'Correcto!';
                        $type = '#06d6a0';
                        $timer = 10000;
                        $msgBody = "Enhorabuena, password reseteado correctamente,
                            redireccionando a la página de login ...<meta http-equiv='refresh' 
                            content='3; " . Url::toRoute("login/index") . "'>";
                    } else {

                        $title = 'Error!';
                        $type = '#ef476f';
                        $msgBody = 'Ha ocurrido un error, no ha podido restablecerse la contraseña.';
                        $timer = 2000;
                    }
                }


                $msg =(object) [
                    'type' => $type,
                    'title' => $title,
                    'body' => $msgBody,
                    'timer' => $timer,
                ];
            } else {
                $model->getErrors();
            }
        }


        return $this->render("resetpass", ["model" => $model, "msg" => $msg]);
    }

}