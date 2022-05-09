<?php

namespace backend\controllers\boda;

use Yii;
use common\models\boda\Invitaciones;
use common\models\boda\InvitacionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\Control;
use yii\helpers\Json;
use yii\helpers\Html;
use common\components\general\MyHelper;
use common\models\boda\Invitados;

/**
 * InvitacionesController implements the CRUD actions for Invitaciones model.
 */
class InvitacionesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


 
    public function actions()
    {
        $Control = new Control;
        if (!$Control->checkAcces()) {
            $Control->RedirectAccess();
        }
        $this->layout ='principal';
       
    }

    /**
     * Lists all Invitaciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvitacionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invitaciones model.
     * @param string $id
     * @return mixed
     */

    public function actionView($id)
    {

        $searchModel = new InvitacionesSearch();
        $model = $searchModel->view($id)->one();
        $UrlWeb = Yii::$app->params['url_web'];
        $UrlQr = $UrlWeb . 'reserva/crear?id=' . $model->id;
        return $this->render('view', [
            'model' => $model,
            'UrlQr' => $UrlQr
        ]);
    }

    /**
     * Creates a new Invitaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invitaciones();

        $Id = (new MyHelper())->GenerateUniqueId();
        $model->id = $Id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Invitados::SaveInvitados($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $model->baby = 0;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Invitaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->creation_date=$model->creation_date=='null'?null:$model->creation_date;
            $model->save();
            Invitados::SaveInvitados($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $Invitados = Invitados::find()->select(['id'])->where(['id_invitacion' => $model->id])->all();
            if ($Invitados) {
                $arr = [];
                foreach ($Invitados as $Invitado) {                    
                    $arr[]=$Invitado->id;
                }   
                $Invitados=array_values($arr);
                $model->invitados =$Invitados;
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate_order()
    {

        if (\Yii::$app->getRequest()->getIsAjax() && Yii::$app->request->get("id")) {
            $id = Html::encode($_GET["id"]);
            $val = Html::encode($_GET["val"]);
            $model = $this->findModel($id);

            $model->order = (int)$val;
            if ($model->validate()) {
                $model->save();
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
            return Json::encode(false);
        }
    }
    /**
     * Deletes an existing Invitaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }



    public function actionUpdateestado()
    {
        if (\Yii::$app->getRequest()->getIsAjax() && Yii::$app->request->post("id")) {
            $id = Html::encode($_POST["id"]);
            $model = $this->findModel($id);

            //$model->scenario = 'status';
            $model->status = $model->status == 1 ? 0 : 1;
            if ($model->validate()) {
                $model->save();
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
            return Json::encode(1);
        }
    }
    public function actionDeleteall()
    {
        //Invitaciones::deleteAll();
        return $this->redirect(['index']);
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
