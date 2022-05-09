<?php

namespace common\components\general;

use common\models\boda\Invitados;
use common\models\boda\Invitaciones;
use common\models\login\Users;
use Yii;
use yii\helpers\ArrayHelper;

class ListOption
{

    public static function getList($options)
    {
        $options = (object)$options;
        $Result = [];
        $MyHelper = new MyHelper();
        $type = $options->type;
        $id = $options->id;
        $name = isset($options->name) ? $options->name : $id;
        $group = isset($options->group) ? $options->group : null;
        $array = isset($options->array) ? $options->array : null;
        $where = isset($options->where) ? $options->where : null;
        $distinct = isset($options->distinct) ? $options->distinct : null;
        $Order = isset($options->order) ? $options->order : false;
        $IsCache = isset($options->cache) ? $options->cache : true;
        $ArrayHelper = isset($options->array_helper) ? $options->array_helper : true;

        $session = Yii::$app->cache;
        $SessionWhere = json_encode($where);
        $SessionGroup = json_encode($group);
        $NameSession = 'List_option_' . $type . '_' . $id . '_' . $name . '_' . $SessionGroup . '_' . $array . '_' . $SessionWhere . '_' . $distinct . '_' . $Order;
        if ($session->get($NameSession) && $IsCache == true) {
            $Result = $session->get($NameSession);
        } else {
            $FindModel = ListOption::FindModel($type, $id, $name, $MyHelper);
            $model = isset($FindModel->model) ? $FindModel->model : '';
            $IsQuery = isset($FindModel->IsQuery) ? $FindModel->IsQuery : true;
            if ($where) {
                $model = $model->where($where);
            }
            if ($ArrayHelper) {
                if ($IsQuery == true) {
                    if ($distinct == true) {

                        $model = $model->distinct();
                    } else if ($group != null) {

                        $model = $model->groupBy($group);
                    }
                    if ($Order != false) {
                        $model = $model->orderBy($Order);
                    }
                    if ($array == true) {
                        $Result = ArrayHelper::map($model->all(), $id, $name);
                    } else {
                        $Result = ArrayHelper::map($model->asArray()->all(), $id, $name);
                    }
                } else {
                    $Result = ArrayHelper::map($model, $id, $name);
                }
            } else {
                $Result = $model->asArray()->all();
            }
            $session[$NameSession] = $Result;
        }
        return $Result;
    }

    private static function FindModel($type, $id, $name, $MyHelper)
    {
        $IsQuery = true;

        switch ($type) {
            case 'Users':
                $model = Users::find([$id, $name])->select([$id, $name]);
                break;
            case 'Invitados':
                $model = Invitados::find([$id, $name])->select([$id, $name]);
                break;
            case 'Invitaciones':
                $model = Invitaciones::find([$id, $name])->select([$id, $name]);
                break;
        }
        return (object)['model' => $model, 'IsQuery' => $IsQuery];
    }

}
