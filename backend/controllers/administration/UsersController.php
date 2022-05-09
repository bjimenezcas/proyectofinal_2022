<?php

namespace backend\controllers\administration;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\controllers\Control;
use common\components\general\MyHelper;
use common\models\login\Users;
use common\models\login\UsersSearch;
use yii\helpers\Json;
use yii\helpers\Html;

class UsersController extends Controller
{
    public function actions()
    {
        $Control = new Control;
        if (!$Control->checkAcces()) {
            $Control->RedirectAccess();
        }
        $this->layout = 'principal';
    }
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new UsersSearch();
        $model = $searchModel->view($id)->one();

        return $this->render('view', [
            'model' => $model
        ]);
    }


    public function actionCreate()
    {
        $model = new Users();
        $MyHelper = new MyHelper();
        $model->scenario = 'register';
        $Id = (new MyHelper())->GenerateUniqueId();
        $model->id = $Id;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $Password = substr(uniqid('', true), 6, 6);
            $model = $MyHelper->SaveModel($model, 'app');
            $model->setPassword($Password);
            $model->generateAuthKey();
            if ($model->validate()) {
                $tmstmp = (new MyHelper())->GetActualDate();
                $model->created_at = $tmstmp;
                $model->save();

                $NewModel = Users::findOne($model->id);
                $subject = "Alta de usuario";
                $content = Yii::$app->controller->renderPartial('@common/mail/email_user', ['model' => $NewModel, 'pass' => $Password]);

                Yii::$app->mailer->compose()
                    ->setTo($model->email)
                    ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                    ->setSubject($subject)
                    ->setHtmlBody($content)
                    ->send();

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->validate()) {

                $tmstmp = (new MyHelper())->GetActualDate();
                $model->updated_at = $tmstmp;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->password = '';
            if (!is_array($model->app)) {
                $model->app = explode(',', $model->app);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionSend_confirm($id)
    {
        $model = Users::findOne(['id' => $id]);
        $model->scenario = 'update';
        $model->password = MyHelper::randKey("abcdef0123456789", 5);
        $Password = $model->password;
        $model->enabled = 0;
        if ($model->validate()) {
            $model->save();
        } else {
            Yii::error("Error model ->" . json_encode($model->getErrors()));
        }

        $table = Users::findOne($model->id);
        $table->setPassword($model->password);
        $table->generateAuthKey();
        if ($table->validate()) {
            $table->save();
        } else {
            Yii::error("Error model ->" . json_encode($table->getErrors()));
        }
        $subject = "Alta de usuario";
        $content = Yii::$app->controller->renderPartial('@common/mail/email_user', ['model' => $model, 'pass' => $Password]);

        Yii::$app->mailer->compose()
            ->setTo($model->email)
            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
            ->setSubject($subject)
            ->setHtmlBody($content)
            ->send();

        return 1;
    }

    public function actionUpdateestado()
    {
        if (\Yii::$app->getRequest()->getIsAjax() && Yii::$app->request->post("id")) {
            $id = Html::encode($_POST["id"]);
            $model = $this->findModel($id);

            $model->scenario = 'status';
            $model->status = $model->status == 1 ? 0 : 1;
            if ($model->validate()) {
                $model->save();
            } else {
                Yii::error("Error model ->" . json_encode($model->getErrors()));
            }
            return Json::encode(1);
        }
    }

    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
