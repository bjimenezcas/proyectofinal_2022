<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAssetPortada extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
        'css/portada.css',
        'css/new_style.css',

        'https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/css/lightgallery-bundle.css',
        'https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/css/lg-autoplay.css'
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js',
        'js/simplyCountdown.js',

        'https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/lightgallery.min.min.js',
        'https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/plugins/zoom/lg-zoom.min.js',
        'https://cdn.jsdelivr.net/npm/justifiedGallery@3.8.1/dist/js/jquery.justifiedGallery.js',
        'https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/plugins/video/lg-video.min.js',
        'https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/plugins/thumbnail/lg-thumbnail.min.js',
        'https://cdn.jsdelivr.net/npm/lightgallery@2.4.0/plugins/autoplay/lg-autoplay.min.js',
        'js/boda.js',
        
    ];
    public $depends = [        
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}

