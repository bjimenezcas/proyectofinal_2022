<?php

namespace common\components\general;

use common\models\administration\AppSubCategory;
use common\models\administration\AppCategorySearch;
use common\models\administration\language\Languages;
use common\models\administration\AppSubCategoryExtend;
use common\models\administration\server\WebAppServerSearch;
use Yii;
use yii\helpers\Url;

class Menu
{


    public static function setImpersonate($result)
    {
        $webUser = Yii::$app->getUser();
        $Impersonate = $webUser->getIsImpersonated();
        $result='';
        if ($Impersonate) {
            $result= '
            <li class="nav-item" title="Volver a usuario Impersonate">
                <a class="nav-link mynav-right" href="'.Url::to(['/main/stop_impersonating']).'">
                <i class="fas fa-user-secret"></i></a>
            </li>';
        }
        return $result;
    }

    public static function getEnvironment($Size, $Categories)
    {

        $BBDD = Yii::$app->session->get('server') ? Yii::$app->session->get('server') : \Yii::t('app', 'Select the environment');

        $Color = '';
        if ($Size == 0) {
            $data[] = ['label' => \Yii::t('app', 'You only have this environment enabled')];
        } else {
            $Color = 'blue';
            $Count = 0;
            $FirstBbdd = '';
            $ExistActualBbdd = false;
            foreach ($Categories as $item) {
                $item = (object)$item;
                if ($item->name != $BBDD) {
                    if ($Count == 0) {
                        $DefaultBbdd = $item->name;
                    }
                    $data[] = ['label' => '<i class="' . $item->glyphicons . '"></i> ' . \Yii::t('app', $item->label),
                        'url' => '#', 'options' => ['onclick' => 'ChangeServer("' . $item->name . '")']];
                } else {
                    $ExistActualBbdd = true;
                    $Color = $item->color;
                    $NewLabelBbdd = $item->label;
                }
                $Count++;
                $FirstBbdd = $Count == 1 ? $item->name : '';
                $Color = $Count == 1 ? $item->color : $Color;
            }
            $BBDD=$NewLabelBbdd;
            //en el caso de cambiar de un menu a otro y no tiene los mismos entornos, hay que comprobarlo
            if (!$ExistActualBbdd) {
                unset($data[0]);
                Yii::$app->session->set('server', $DefaultBbdd);
                $BBDD = $DefaultBbdd;
            }
            if ($Count == 1) {
                $data[0] = ['label' => \Yii::t('app', 'Only have this environment')];
                if ($FirstBbdd != $BBDD) {
                    Yii::$app->session->set('server', $FirstBbdd);
                    $BBDD = Yii::$app->session->get('server') ? Yii::$app->session->get('server') : 'Selecciona el entorno';
                }
            }
        }
        return (object)['BBDD' => $BBDD, 'data' => $data, 'Color' => $Color];
    }



    public static function CheckSession($type, $param)
    {
        $session = Yii::$app->cache;

        $User = Yii::$app->user->identity->getId();
        if (isset($session[$User . '_' . $type . '_' . $param])) {
            $Result = $session[$User . '_' . $type . '_' . $param];
        } else {
            if ($type == 'Category') {
                $Result = AppCategorySearch::MyRel('menu')->asArray()->all();
            } else if ($type == 'SubCategory') {
                $Result = AppSubCategory::getSubcategoryUser($param)->asArray()->all();
            } else if ($type == 'extend') {
                $Result = AppSubCategoryExtend::find()
                    ->where(['status' => 1, 'id_sub_category' => $param])
                    ->orderBy('sort asc')->asArray()->all();
            }else if ($type == 'environment') {
                $Result = WebAppServerSearch::getServers()->asArray()->all();
            }
            Menu::SendCache($type, $param, $Result);
        }
        return $Result;
    }

    public static function SendSession($type, $param, $data)
    {
        $IsCache = Yii::$app->params["enable_cache_menu"];
        if ($IsCache) {

            $session = Yii::$app->session;
            $session[$type . '_' . $param] = $data;
        }
        return true;
    }

    public static function SendCache($type, $param, $data, $user = true)
    {

        $IsCache = Yii::$app->params["enable_cache_menu"];
        if ($IsCache) {
            $cache = Yii::$app->cache;
            $NameCache = '';
            if ($user) {
                $User = Yii::$app->user->identity->getId();
                $NameCache .= $User . '_';
            }
            $NameCache .= $type . '_' . $param;
            $cache[$NameCache] = $data;
        }
        return true;
    }

    public static function getIdioms()
    {
        $session = Yii::$app->cache;
        $type = 'idioms';
        if (isset($session[$type . '_' . $type])) {
            $Idioms = $session[$type . '_' . $type];
        } else {
            $Idioms = Languages::find()->where(['status' => 1])->orderBy('sort')->asArray()->all();
            Menu::SendCache($type, $type, $Idioms, false);
        }
        $Result = [];
        foreach ($Idioms as $Idiom) {
            $Idiom = (object)$Idiom;
            $Result[] = ['label' => '<i class="' . $Idiom->icon . '"></i> ' . Yii::t('app', $Idiom->name),
                'url' => '#',
                'options' => ['onclick' => 'ChangeLanguage("' . $Idiom->code . '")', 'class' => Yii::$app->user->identity->language == $Idiom->code ? 'active' : '']];
        }

        return $Result;
    }

    public static function NewgetMenuRight($Category, $SubCategory)
    {
        $result='';
        $result.= Menu::setImpersonate($result);
        $Environment = Menu::CheckSession('environment', $Category);//obtenemos el entorno
        $Size = $Environment == false ? 1 : count($Environment);
        //$Idioms = Menu::getIdioms();
        if ($Size > 1 && !in_array($SubCategory,['empty',''])) {
            $Environment = (object)$Environment;
            $Environment = Menu::getEnvironment($Size, $Environment);
            $Class='mynav-right btn btn-sm ';
            if($Environment->BBDD=='prod')
            {
                //$Class='btn btn-sm ';
            } 
            if($Environment->data)
            {
               $result.=Menu::LoopEnvironment($Environment,$Class);
            }else{
                $result.= '
                <li class="nav-item '.$Class.'">
                    <a class="nav-link" href="#">
                    <i class="fa fa-podcast" style="background-color:'. $Environment->Color.'"></i> ' . \Yii::t('app', $Environment->BBDD) . '</a>
                </li>';
            }

        }

        $result.= '
                <li class="nav-item">
                    <a class="nav-link mynav-right" href="'.Url::to(['/main/account']).'" title="Usuario"><i class="fas fa-user-circle"></i> <span class="align-top">' . Yii::$app->user->identity->username . '</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mynav-right" href="'.Url::to(['/login/logout']).'" title="LogOut"><i class="bi bi-door-closed-fill"></i>  </a>
                </li>';
        return $result;
    }
    public static function NewgetMenuLeft($type, $Category, $SubCategory)
    {
        $Result = '';
        $Categories = Menu::CheckSession($type, $Category);//obtenemos las categorias
        $Size = count($Categories);
        if ($Size == 0) {
            $Result.='
      <span class="navbar-text">
        No tienes asignada ninguna categoria, por favor contacte con su administrador
      </span>';
        } else {
                $Result.= Menu::LoopCategories($Categories,$Category,$SubCategory);
        }
        return $Result;
    }
    public static function LoopCategories($Categories,$Category,$SubCategory)
    {
        $Result='';
        foreach ($Categories as $item) {
            $item = (object)$item;
            $SubCategories = Menu::CheckSession('SubCategory', $item->id);
            $Url = $item->url;
            $Active='';
            if($Category==$item->id)
            {
                $Active='active';
            }
            if($SubCategories)
            {
                $Result.= Menu::LoopSubCategories($SubCategories,$item,$Active,$SubCategory);
            }else{
                $Result.='<li class="nav-item"><a class="nav-link btn '.$Active.' nav-first" aria-current="page" href="'.Url::to([$Url]).'" title="'.Yii::t('app', $item->label).'"><span class="' .$item->glyphicons.'"></span> '.Yii::t('app', $item->label).'</a></li>';
            }
        }
        return $Result;
    }
    public static function LoopSubCategories($SubCategories,$Category,$Active,$SubCategory)
    {
        $Result='<li class="nav-item dropdown  ">
                    <a class="nav-link btn dropdown-toggle '.$Active.' dropdown-menu-first nav-first" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="' .$Category->glyphicons.'"></span> '.Yii::t('app', $Category->label).'
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  ';
        foreach ($SubCategories as $item) {
            $item = (object)$item;
            $Extend = Menu::CheckSession('extend', $item->id);
            $Active='';
            if($SubCategory==$item->id)
            {
                $Active='active';
            }
            if($Extend)
            {
                $Result.= Menu::LoopSubCategoriesExtend($Extend,$item,$Active);
            }else
            {
                $Result.='<li><a class="dropdown-item '.$Active.'" href="'.Url::to([$item->url]).'" title="'.Yii::t('app', $item->label).'"><span class="' .$item->glyphicons.'"></span> '.Yii::t('app', $item->label).'</a></li>';
            }

        }

        $Result.='</ul></li>';
        return $Result;
    }    public static function LoopSubCategoriesExtend($SubCategories,$Category,$Active)
{
    $Result='<li class="nav-item dropdown special_dropdown dropend ">
                    <a class="nav-link dropdown-toggle '.$Active.' dropdown-menu-second" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="' .$Category->glyphicons.'"></span> '.Yii::t('app', $Category->label).'
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  ';
    foreach ($SubCategories as $item) {
        $item = (object)$item;
        $Active='';
            $Result.='<li><a class="dropdown-item '.$Active.'" href="'.Url::to([$item->url]).'" title="'.Yii::t('app', $item->label).'"><span class="' .$item->glyphicons.'"></span> '.Yii::t('app', $item->label).'</a></li>';


    }

    $Result.='</ul></li>';
    return $Result;
}
    public static function LoopEnvironment($Environment,$Class)
    {
        $Result='<li class="nav-item dropdown  '.$Class.' environment_li"  style="background-color:'. $Environment->Color.'">
                    <a class="nav-link dropdown-toggle btn btn-sm" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-podcast"></i> ' . \Yii::t('app', $Environment->BBDD) . '
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  ';
        foreach ($Environment->data as $Data) {

            $Data = (object)$Data;
            $Result.='<li onclick=\''.$Data->options['onclick'].'\'><a class="dropdown-item" href="#" > '.Yii::t('app', $Data->label).'</a></li>';

        }

        $Result.='</ul></li>';
        return $Result;

    }

}
