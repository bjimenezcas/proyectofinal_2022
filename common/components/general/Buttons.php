<?php

namespace common\components\general;

use Yii;
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

class Buttons
{

    public static function getConfigDynagrid($dataProvider, $searchModel, $Columns, $Name, $IdDynagrid = null, $Config = null)
    {
        if ($IdDynagrid == null) {
            $IdDynagrid = Yii::$app->session->get('dynagrid') . (Yii::$app->session->get('dynagrid_ext', 0) == 0 ? '' : Yii::$app->session->get('dynagrid_ext'));
        }
        $IdDynagrid='dynagrid-'.$IdDynagrid;
        $Storage = 'session';
        //$Storage = 'db';
        $Icon = '<span class="' . Yii::$app->session->get('glyphicons') . '"></span>';
   
        $ConfigDynagrid = [
            'options' => ['id' => $IdDynagrid],
            //'moduleId'=>'abcdf',
            'storage' => $Storage,
            'toggleButtonGrid' => ['class' => 'me-md-1'],
            'toggleButtonFilter' => ['class' => 'me-md'],
            'toggleButtonSort' => ['class' => 'me-md'],
            'gridOptions' => [
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'panel' => [
                    'type'=>GridView::TYPE_SUCCESS,
                    //'before' => Buttons::getBeforePanel(), //not need
                    'heading' => '<h5 class="panel-title">' . $Icon . ' ' . $Name . '</h5>',
                ],
                /**
                 * 'floatHeader' => true,
                 * 'floatHeaderOptions' => [
                 * 'position' => 'absolute'
                 * ],
                 * /* */
                'resizableColumns' => false,
                'persistResize' => false,
                'hideResizeMobile' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'toolbar' => [
                    '{export}{dynagridFilter}{dynagridSort}{dynagrid}',
                    //buttons::getFullExport($dataProvider, $Columns, $Name),
                ],
                'exportConfig' => Buttons::getExportConfig($Name),
                'pjax' => true, // try to change 24_05_2018
                'responsive' => true,
                'responsiveWrap' => false,
                'export' => Buttons::getExport($dataProvider, $Columns, $Name),
            ]];

        return $ConfigDynagrid;
    }



    public static function getFullExport($dataProvider, $Columns, $FileName)
    {
        $Date = date('dmYHis');

        $SizeButton = Yii::$app->session->get('button_size');
        $fullExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $Columns,
            'fontAwesome' => true,
            'asDropdown' => false,
            'target' => ExportMenu::TARGET_BLANK,
            'folder' => '@app/runtime/export',
            //'stream' => true,
            'deleteAfterSave' => true, // this will delete the saved web file after it is streamed to browser,
            'exportConfig' => [
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_EXCEL_X => [
                    'icon' => 'fas fa-file-excel',
                    'label' => 'Excel',
                    'options' => ['class'=>'dropdown-item','class'=>'dropdown-item icon_full_export'],
                ],
                ExportMenu::FORMAT_TEXT => [
                    'label' => Yii::t('kvexport', 'CSV'),
                    'icon' => 'fas fa-file-csv',
                    'iconOptions' => ['class' => 'text-primary'],
                    'linkOptions' => [],
                    'options' => ['title' => Yii::t('kvexport', 'Comma Separated Values'),'class'=>'dropdown-item icon_full_export'],
                    'alertMsg' => Yii::t('kvexport', 'The CSV export file will be generated for download.'),
                    'mime' => 'application/csv',
                    'extension' => 'csv',
                    'writer' => ExportMenu::FORMAT_CSV,
                    'delimiter' => ";",
                ],
            ],
            'filename' => $FileName . '-' . $Date,
            'showConfirmAlert' => false,
            'pjaxContainerId' => 'kv-pjax-container',
            'columnSelectorOptions' => ['class' => $SizeButton],
            'dropdownOptions' => [
                'label' => 'Full',
                'class' => 'btn btn-warning ' . $SizeButton,
                'itemsBefore' => [
                    '<li class="dropdown-header">Export All Data</li>',
                ],
            ],
        ]);
        return $fullExportMenu;
    }

    public static function getExportConfig($FileName)
    {
        $Date = date('dmYHis');
        $ExportMenu = [
            GridView::HTML => [
                'icon' => 'fas fa-file-alt',
                'filename' => $FileName . '-' . $Date,
            ],
            GridView::CSV => [
                'icon' => 'fas fa-file-csv',
                'filename' => $FileName . '-' . $Date,
            ],
            GridView::TEXT => [
                'icon' => 'far fa-file-alt',
                'filename' => $FileName . '-' . $Date,
            ],
            GridView::PDF => [
                'icon' => 'fas fa-file-pdf',
                'filename' => $FileName . '-' . $Date,
            ],
            GridView::JSON => [
                'icon' => 'fas fa-file-code',
                'filename' => $FileName . '-' . $Date,
            ],
            GridView::EXCEL => [
                'icon' => 'fas fa-file-excel',
                'filename' => $FileName . '-' . $Date,
            ]
        ];
        return $ExportMenu;
    }

    public static function getExport($dataProvider = null, $Columns = null, $Name = null)
    {
        if ($dataProvider == null && $Columns == null && $Name == null) {

            $SizeButton = Yii::$app->session->get('button_size');
            $Result = [
                'icon' => 'fas fa-file-alt',
                'options' => ['class' => 'btn-warning' . $SizeButton],
                'label' => Yii::t('app', 'Page'),
                'fontAwesome' => true,
                'target' => ExportMenu::TARGET_BLANK,
                'showConfirmAlert' => false,
            ];
        } else {
            $Result = [
                'options' => ['class' => 'btn-warning'],
                'icon' => 'fas fa-external-link-alt',
                'itemsAfter' => [
                    '<div role="presentation" class="dropdown-divider"></div>',
                    '<div class="dropdown-header">Export All Data</div>',
                    buttons::getFullExport($dataProvider, $Columns, $Name)
                ]
            ];
        }
        return $Result;
    }


    public static function getButtons($config = false)
    {
        $params = '';
        $method = '';
        if ($config) {
            $config = (object)$config;
            if (isset($config->params)) {
                $params = $config->params;
                $method = 'post';
            }
        }
        $create = Html::a('<i class="fas fa-plus"></i>', ['create'], [
            //'type'=>'button',
            'title' => Yii::t('app', 'Add'),
            'class' => 'btn  btn-primary ', 'data-pjax' => 0,
        ]);
        $repeat = Html::a('<i class="fas fa-redo"></i>', [''], [
            'data-pjax' => 0,
            'class' => 'btn  btn-dark ',
            'title' => Yii::t('app', 'Reset')
        ]);
        $IconZoom = Yii::$app->session->get('zoom') == 1 ? 'fa fa-search-minus' : 'fa fa-search-plus';
        $Zoom = Html::a('<i class="' . $IconZoom . '"></i>', Url::to(['main/zoom', 'zoom' => Yii::$app->session->get('zoom')]), [
            'data-pjax' => 0,
            'class' => 'btn  btn-info ',
            'title' => Yii::$app->session->get('zoom') != 1 ? Yii::t('app', 'Zoom in') : Yii::t('app', 'Zoom out')
        ]);
     
       
        return (object)[ 'create' => $create, 'repeat' => $repeat, 'zoom' => $Zoom, ];
    }

}
