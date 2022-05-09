<?php

namespace backend\controllers;

use common\models\boda\Invitaciones;
use common\models\boda\Invitados;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BodaController extends Controller
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

    public function getIdentifier()
    {
        $Category = '9fc2327e-ffe6-107d-89bb-ced363ad62'; //Boda
        $SubCategory = 'c44c7950-1aa3-7c4f-d3ff-6d1044c507'; //Boda_Dashboard
        $SubCategoryExt = null;
        return (object)['category' => $Category, 'subcategory' => $SubCategory, 'ext_subcategory' => $SubCategoryExt];
    }

    public function actionIndex()
    {
        $Invitados=Invitados::find()->count();
        $Invitados_ok=Invitados::find()->where(['confirmation'=>1,'finish'=>1])->count();
        $Invitados_ko=Invitados::find()->where(['confirmation'=>0,'finish'=>1])->count();
        $Invitaciones=Invitaciones::find()->count();
        $Invitaciones_finish=Invitaciones::find()->where(' creation_date is not null')->count();
        $Tables=Invitados::find()->where(['!=','table',''])->orderBy('table')->all();
        return $this->render('index', [
            'Invitados' => $Invitados,
            'Invitados_ok' => $Invitados_ok,
            'Invitados_ko' => $Invitados_ko,
            'Invitaciones' => $Invitaciones,
            'Invitaciones_finish' => $Invitaciones_finish,
            'Tables' => $Tables,
        
        ]);
    }

}
