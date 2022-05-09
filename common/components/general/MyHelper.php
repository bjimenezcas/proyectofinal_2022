<?php

namespace common\components\general;

use common\models\administration\server\WebAppServer;
use kartik\grid\GridView;
use Yii;
use yii\helpers\Url;

class MyHelper
{
    

    public function GenerateBreadcrum($AData)
    {

        if ($AData) {
            $numItems = count($AData);
            $i = 0;
            $Result = '<nav style="--bs-breadcrumb-divider: \'>\';" aria-label="breadcrumb">
            <ol class="breadcrumb">';
            foreach ($AData as $Element) {
                $active = '';
                $class = 'class="breadcrumb-item';
                if (++$i === $numItems) {
                    $class .= ' ' . $active . '" aria-current="page';
                }
                $class .= '"';
                if (isset($Element['url'])) {
                    $Url = Url::to($Element['url']);
                    $label = '<a href="' . $Url . '">' . $Element['label'] . '</a>';
                } else {
                    $label = isset($Element['label']) ? $Element['label'] : $Element;
                }
                if($i==1)
                {
                    $label='<i class="far fa-dot-circle" style="margin-right: 0.2em;"></i>'.$label;
                }
                $Result .= '<li ' . $class . '>' . $label . '</li>';
            }
            $Result .= '</ol></nav>';
        }
        return $Result;
    }
    public function DateRange($Date,$AExtraData=null)
    {
        if (is_array($Date)) {
            foreach ($Date as $Dat) {
                $Result = MyHelper::DateConfig($Dat, $AExtraData);
            }
        } else {
            $Result = MyHelper::DateConfig($Date, $AExtraData);
        }
        return $Result;
    }
    
    public static function truncateText($text, $max_len)
    {
        $len = strlen($text);
        $Text = '';
        if ($len <= $max_len) {
            $Text = $text;
        } else {
            $Text = substr($text, 0, $max_len - 1) . '...';
        }
        return $Text;
    }
    public function DateConfig($Date, $AExtraData)
    {
        $Format=isset($AExtraData['format'])?$AExtraData['format']:null;
        $Group=isset($AExtraData['group'])?$AExtraData['group']:false;
        $Result = [
            'attribute' => $Date, 'format' => 'raw', 'group' => $Group,
            'headerOptions' => ['style' => 'min-width:230px'],
            'filterType' => GridView::FILTER_DATE_RANGE,
            'value' => function ($model, $key, $index, $widget) use ($Date, $Format) {
                if ($Format == null) {
                    return $model->$Date;
                } else {
                    return date($Format, strtotime($model->$Date));
                }
            },
            'filterWidgetOptions' => [
                'language' => Yii::$app->session->get('language'),
                'presetDropdown' => true,
                //'value' => false,
                /* 'defaultPresetValueOptions' => [
                  'tag'=>'span',
                  'style'=>'display:inline-block;width:40px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis'
                  ], */
                'convertFormat' => true,
                //'hideInput'=>true,
                //'useWithAddon'=>true,
                'defaultPresetValueOptions' => ['style' => 'display:none'],
                'pluginOptions' => [
                    'autoclose' => true,
                    //'opens' => 'right',
                    'locale' => ['format' => 'Y-m-d',
                        'cancelLabel' => Yii::t('app', 'Clear')],
                ],
                'pluginEvents' => [
                    'show.daterangepicker' => 'function(ev, picker) {
            picker.container.find(".ranges").off("mouseenter.daterangepicker", "li");
            if($(this).val() == "") {
                picker.container.find(".ranges .active").removeClass("active");
            }
        }',
                    "cancel.daterangepicker" => "function(ev, picker) {
                        picker.element[0].children[1].textContent = '';
                        $(picker.element[0].nextElementSibling).val('').trigger('change');
                        }",
                    'apply.daterangepicker' => 'function(ev, picker) { 
                        var val = picker.startDate.format(picker.locale.format) + picker.locale.separator +
                        picker.endDate.format(picker.locale.format);

                        picker.element[0].children[1].textContent = val;
                        $(picker.element[0].nextElementSibling).val(val);
                        }',
                ],
            ]
        ];
        return $Result;
    }
    public function FindDescription($ids, $type, $method = null)
    {
        $Name = '';
        $ids = str_replace(',', "','", $ids);
        $where = 'id in (\'' . $ids . '\')';
        if ($ids != '') {
            if ($type == 'App') {
                $model = \common\models\administration\Application::find()->where($where)->all();
                $Name = 'name';
            } else if ($type == 'AppServer') {
                $model = WebAppServer::find()->where($where)->all();
                $Name = 'name';
            }
            $i = 0;
            $Result = '';
            foreach ($model as $data) {
                if ($i != 0) {
                    $Result .= ';';
                }
                $Result .= $data->$Name;
                $i++;
            }

        } else {
            $Result = '';

        }
        return $Result;
    }
    public static function GetBbdd($Environment, $Type)
    {
        $Result = '';
        if ($Type == 'Multichannel') {
            if ($Environment == 'prod') {
                $Result = 'db_multichannel_pro';
            } elseif ($Environment == 'pre') {
                $Result = 'db_multichannel_pre';
            } elseif ($Environment == 'dev') {
                $Result = 'db_multichannel_dev';
            }
        }
        return $Result;
    }
    public static function DetectColor($model, $type)
    {
        $Result = [];
        if ($type == 'log_webservice_ahorro') {
            if (stristr($model->error_description, '"code":200') == TRUE ||
                stristr($model->error_description, '"description":"OK"') == TRUE) {
                return ['class' => 'success'];
            } else if (stristr($model->error_description, 'Contacto Cancelado') == TRUE) {
                return ['class' => 'warning'];
            }
        } else if ($type == 'log_webservice_card') {
            if (stristr($model->error_description, '"code":200') == TRUE ||
                stristr($model->error_description, '"status":"200"') == TRUE) {
                return ['class' => 'success'];
            } else if (stristr($model->error_description, '"status":"400"') == TRUE) {
                return ['class' => 'warning'];
            }

        }

        return $Result;
    }

}
