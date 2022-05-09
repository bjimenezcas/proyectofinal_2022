<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use common\models\boda\Invitaciones;
use common\components\general\MyHelper;
use common\models\boda\Invitados;

class ReservaController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $this->layout = 'reserva';
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['/main/index']);
    }
        public function actionCrear($id)
        {
        $model = $this->findModel($id);
        $Invitados = Invitados::find()->where(['id_invitacion' => $id])->all();
        $request = Yii::$app->request;
        if ($model && $request->isPost) {
            $tmstmp = (new MyHelper())->GetActualDate();
            $Confirmation = $request->post('confirmation_hidden', 0);
            $model->confirmation = $Confirmation == '1' ? 1 : 0;
            $model->observation = $request->post('description', '');
            $model->creation_date = $tmstmp;
            if ($model->validate()) {
                $model->save();                
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
            foreach ($Invitados as $Invitado) {
                $Id = $Invitado->id;
                if($Confirmation == '1')
                {
                    $InvitadoConfirmation = $request->post('confirmation_' . $Id, 0);
                    $Invitado->confirmation = $InvitadoConfirmation == 'on' ? 1 : 0;
                }else{
                    $Invitado->confirmation =0;
                }
                $Invitado->type_menu = $request->post('type_menu_' . $Id, 0);
                $Invitado->fish_or_meat = $request->post('fish_or_meat_' . $Id, 0);
                $Allergens= $request->post('allergens_' . $Id, 0);
                $Invitado->allergens = $Allergens==''?1:0;
                $Bus= $request->post('bus_' . $Id, 0);
                $Invitado->bus = $Bus==''?1:0;
                $Invitado->finish =1;
                if ($Invitado->validate()) {
                    $Invitado->save();                
                } else {
                    Yii::error("Error model ->" . json_encode($Invitado->getErrors()));
                }
            }
            return $this->redirect(['thanks']);
        } else if($model && ($model->confirmation==1 || $model->creation_date!=null )){
            return $this->redirect(['/main/index']);
        } else {
            return $this->render('crear', [
                'model' => $model,
                'Invitados' => $Invitados,
            ]);
        }
    }
    public function actionThanks()
    {
        return $this->render('thanks', []);
    }

    protected function findModel($id)
    {

        if (($model = Invitaciones::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
