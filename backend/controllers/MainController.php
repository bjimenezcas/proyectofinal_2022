<?php

namespace backend\controllers;

use common\components\general\MyHelper;
use common\components\general\WebUser;
use common\models\login\FormRegister;
use common\models\login\LoginForm;
use common\models\login\Users;
use common\models\administration\Opinions;
use Yii;
use yii\filters\AccessControl;
use common\models\administration\server\WebAppServer;
use yii\web\Controller;

class MainController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'except' => ['login'],
            //'denyCallback'=>['logout'],
            'rules' => [
                [
                    'allow' => true,
                ]
            ],
        ];

        return $behaviors;
    }

   
    public function actions()
    {
        $Control = new Control;
        if (!$Control->checkAcces()) {
            $Control->RedirectAccess();
        }
        $this->layout ='principal';
       
    }



    public function actionHealth()
    {
        $this->layout = 'empty';
        return $this->render('health', []);

    }

    public function actionIndex()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
        } else {
                return $this->redirect(['boda/index']);            
        }
    }

    public function actionError()
    {

        $this->layout = 'login';
        return $this->render('error');
    }


    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionMaps()
    {
        return $this->render('maps');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAccountpass()
    {
        $model = new FormRegister;
        $model->scenario = 'accountpass';
        $msg = null;
        $id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = Users::findOne($id);
                if ($table) {
                    $tmstmp = (new MyHelper())->GetActualDate();
                    $table->scenario = 'accountpass';
                    $table->setPassword($model->password);
                    $table->generateAuthKey();
                    $table->updated_at =$tmstmp;

                    if ($table->update()) {
                        $title = 'Correcto!';
                        $type = '#06d6a0';
                        $msgBody = 'Sus contraseña se ha cambiado. Refresca la pagina y logeate de nuevo';
                        $timer = 3000;
                    } else {
                        $title = 'Warning!';
                        $type = '#be882f';
                        $msgBody = 'El Usuario no ha podido ser actualizado';
                        $timer = 3000;
                    }
                } else {
                    $title = 'Warning!';
                    $type = '#be882f';
                    $msgBody = "El Usuario seleccionado no ha sido encontrado";
                    $timer = 3000;
                }
            } else {
                $title = 'Error!';
                $type = '#ef476f';
                $msgBody = 'Error en la validación.';
                $timer = 3000;
            }
            $msg =(object) [
                'type' => $type,
                'title' => $title,
                'body' => $msgBody,
                'timer' => $timer,
            ];
        }
        /*
          if (Yii::$app->request->get())
          { */
        if ((int)$id) {
            $table = Users::findOne($id);
            if ($table) {
                $model->id = $table->id;
            } else {
                $mensaje = 'Ha surgido un error al editar el usuario';
                return $this->redirect(["main/index", "mensaje" => $mensaje]);
            }
        } else {
            $mensaje = 'Ha surgido un error al editar el usuario';
            return $this->redirect(["main/index", "mensaje" => $mensaje]);
        }
        return $this->render("accountpass", ["model" => $model, "msg" => $msg]);
    }

    public function actionAccount()
    {

        $id = Yii::$app->user->id;
        $model = Users::findOne($id);
        $model->scenario = 'account';
        $msg = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                $title = 'Correcto!';
                $type = '#06d6a0';
                $msgBody = 'Sus datos han sido actualizado correctamente';
                $timer = 3000;
            } else {
                $title = 'Error!';
                $type = '#ef476f';
                $msgBody = 'Error en la validación.';
                $timer = 3000;
            }

            $msg =(object) [
                'type' => $type,
                'title' => $title,
                'body' => $msgBody,
                'timer' => $timer,
            ];
        }
        return $this->render("account", ["model" => $model, "msg" => $msg]);
    }




    public function GenerateSecret()
    {
        $manager = new Manager();
        $Secret = $manager->generateSecretKey();
        return $Secret;
    }


    public function actionCreate()
    {

        return $this->redirect(['main/user_procedures/index']);
        //return $this->render('create');
    }

}
