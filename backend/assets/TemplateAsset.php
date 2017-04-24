<?php
/**
 * @link SUNGOAL-ZQ
 * @copyright Copyright (c) 2015 SUNGOAL-ZQ
 * @license SUNGOAL-ZQ
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TemplateAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web/frontend/template/';
    public $css = [
    	'upbond/css/bootstrap.min.css',
        // 'upbond/css/icons.css',
        'iconfont/iconfont.css',
        'upbond/css/style.css',
        'upbond/assets/css/main.min.css',
    ];
    public $js = [
    	'upbond/js/jquery.min.js',
        'upbond/js/bootstrap.min.js',
        'upbond/js/modernizr.min.js',
        'upbond/js/detect.js',
        'upbond/js/fastclick.js',
        'upbond/js/jquery.slimscroll.js',
        'upbond/js/jquery.blockUI.js',
        'upbond/js/waves.js',
        'upbond/js/wow.min.js',
        'upbond/js/jquery.nicescroll.js',
        'upbond/js/jquery.scrollTo.min.js',
        'upbond/js/app.js',
    ];
    public $depends = [
          // 'yii\web\YiiAsset',
          // 'backend\assets\IEhack'
    ];
    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [
            TemplateAsset::className(),
            "depends" => "backend\assets\TemplateAsset"
        ]);
    }
    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [TemplateAsset::className(), "depends" => "backend\assets\TemplateAsset"]);
    }

}
