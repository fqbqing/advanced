<?php
/**
 * Class UrlService
 */

namespace common\services;

use yii;
use yii\helpers\Url;

//统一管理链接 并规范书写
class UrlService{
	//返回一个 内部链接
	public static function buildUrl( $uri,$params = [] ){
		return Url::toRoute( array_merge( [ $uri ] ,$params) );
	}

	//返回一个空链接
	public static function buildNullUrl(){
		return "javascript:void(0);";
	}
	//图片链接
    public static function buildStaticPic($path,$params = []){

	    $prefix = Yii::$app->params['prefix'];
        $domain = Yii::$app->params['domains']['static'];
       /* if( stripos($domain,"http") === false ){
            $domain = "http:".$domain;
        }*/

        $url = $domain.$prefix.$path;
        //$url = $prefix.$path;

        return $url;
    }

}