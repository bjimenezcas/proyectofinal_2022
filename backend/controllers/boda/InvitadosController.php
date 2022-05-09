<?php

namespace backend\controllers\boda;

use Yii;
use common\models\boda\Invitados;
use common\components\general\MyHelper;
use common\models\boda\InvitadosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\Control;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * InvitadosController implements the CRUD actions for Invitados model.
 */
class InvitadosController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new InvitadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

 
    public function actionView($id)
    {

        $searchModel = new InvitadosSearch();
        $model = $searchModel->view($id)->one();

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Invitados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invitados();


        $Id = (new MyHelper())->GenerateUniqueId();
        $model->id = $Id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Invitados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
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
    public function actionUpdate_invitacion()
    {

        if (\Yii::$app->getRequest()->getIsAjax() && Yii::$app->request->get("id")) {
            $id = Html::encode($_GET["id"]);
            $val = Html::encode($_GET["val"]);
            $model = $this->findModel($id);

            $model->id_invitacion = $val;
            if ($model->validate()) {
                $model->save();
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
            return Json::encode(false);
        }
    }
    public function actionUpdate_table()
    {

        if (\Yii::$app->getRequest()->getIsAjax() && Yii::$app->request->get("id")) {
            $id = Html::encode($_GET["id"]);
            $val = Html::encode($_GET["val"]);
            $model = $this->findModel($id);

            $model->table = $val;
            if ($model->validate()) {
                $model->save();
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
            return Json::encode(false);
        }
    }
    public function actionUpdate_type_menu()
    {

        if (\Yii::$app->getRequest()->getIsAjax() && Yii::$app->request->get("id")) {
            $id = Html::encode($_GET["id"]);
            $val = Html::encode($_GET["val"]);
            $model = $this->findModel($id);

            $model->type_menu = $val;
            if ($model->validate()) {
                $model->save();
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
            return Json::encode(false);
        }
    }
    public function actionUpdate_gender()
    {

        if (\Yii::$app->getRequest()->getIsAjax() && Yii::$app->request->get("id")) {
            $id = Html::encode($_GET["id"]);
            $val = Html::encode($_GET["val"]);
            $model = $this->findModel($id);

            $model->gender = $val;
            if ($model->validate()) {
                $model->save();
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
            return Json::encode(false);
        }
    }
    /**
     * Deletes an existing Invitados model.
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
        //Invitados::deleteAll();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {

        if (($model = Invitados::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
