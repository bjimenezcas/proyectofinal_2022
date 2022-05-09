<?php

namespace backend\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

class AdministrationController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
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
        return $this->render('index', []);
    }

}
