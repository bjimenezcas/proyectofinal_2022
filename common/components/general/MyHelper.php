<?php

namespace common\components\general;

use common\models\administration\server\WebAppServer;
use DateTime;
use DateTimeZone;
use kartik\grid\GridView;
use Yii;
use yii\helpers\Url;

class MyHelper
{
    public static function getOrder($j)
    {
        $Orders = [];
        for ($i = 1; $i <= $j; $i++) {
            $Orders[$i] = $i;
        }
        return $Orders;
    }
    public function GetDatetime()
    {
        $tmstmp = new DateTime('now', new DateTimeZone('Europe/Madrid'));
        return $tmstmp;
    }
    public function GetActualDate()
    {
        $tmstmp = (new MyHelper())->GetDatetime();
        $tmstmp = $tmstmp->format("Y-m-d H:i:s.u");
        return $tmstmp;
    }
    public static function GenerateUniqueId()
    {
        $tmstmp = (new MyHelper())->GetActualDate();
        $string = md5($tmstmp);
        $string = hash('SHA512', $string);
        $string = substr($string, 0, 8) . '-' .
            substr($string, 8, 4) . '-' .
            substr($string, 12, 4) . '-' .
            substr($string, 16, 4) . '-' .
            substr($string, 20, 10);
        return $string;
    }
    public static function PreventLoop($Type = 'error', $Options = null)
    {
        $Result = ['result' => 'ko', 'message' => 'Se ha llegado al limite de redirecciones, actualice el navegador.'];
        $Url = '';
        $Time = '1';
        if (isset($Options)) {
            if (isset($Options['time'])) {
                $Time = $Options['time'];
            }
        }
        if ($Type == 'error') {
            $Url = "<meta http-equiv='refresh' content='$Time; " . Url::toRoute("main/index") . "'>";
        } elseif ($Type == 'accescorrect') {
            $Referrer = $Options['Referrer'];
            $Url = "<meta http-equiv='refresh' content='0; " . Url::toRoute(["main/index", 'redirect' => $Referrer]) . "'>";
        } elseif ($Type == 'login') {
            $Url = "<meta http-equiv='refresh' content='$Time; " . Url::toRoute("login/index") . "'>";
        }

        $SessionError = Yii::$app->session->get('error_loop', 0);
        if ($SessionError >= 10) {
            Yii::$app->session->set('error_loop', 0);
        } else {
            Yii::$app->session->set('error_loop', ($SessionError + 1));

            $Result = ['result' => 'ok', 'url' => $Url, 'message' => Yii::t('app', 'Redirecting') . '......'];
        }
        Yii::warning(" ->" . json_encode($Type));
        Yii::warning(" ->" . json_encode($Options));

        return (object)$Result;
    }

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

    public function FilterDate($Dates, $Query, $thiss, $type = 'normal')
    {
        if ($Dates) {
            foreach ($Dates as $LDates) {
                //Yii::warning(" ->" . json_encode($Dates));
                foreach ($LDates as $Alias => $NameDate) {
                    if ($thiss->$NameDate) {
                        $Column = $Alias . $NameDate;
                        $Date = explode(' - ', $thiss->$NameDate);
                        if ($type == 'normal') {
                            $StartDate = date('Y-m-d '/*                                             * .'H:i:s'/*/, strtotime($Date[0])) // . ' 00:00:00'/*/
                            ;
                            $EndDate = date('Y-m-d '/*                                             * .'H:i:s'/*/, strtotime($Date[1])) // . ' 23:59:59'/*/
                            ;
                        } elseif ($type == 'special') {
                            $StartDate = strtotime($Date[0]);
                            $EndDate = strtotime($Date[1]);
                        }
                        $Query->andFilterWhere(['>=', $Column, $StartDate,])
                            ->andFilterWhere(['<=', $Column, $EndDate,]);
                    }
                }
            }
        }
        return $Query;
    }
}
