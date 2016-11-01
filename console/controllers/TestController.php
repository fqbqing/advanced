<?php

/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 16/10/12
 * Time: 下午6:34
 */
namespace console\controllers;
class TestController extends \yii\console\Controller
{
    /**
     * 计算下一月日期
     */
    public function actionIndex()
    {
        $items = \common\components\helpers\DateHelper::getMonthPeriod();
        echo '<pre>';
        var_dump( $items );
        echo '</pre>';
        exit;
        return;
    }


    public function actionTest()
    {
        if('fafsadf'==0){
            echo true;
        }else{
            echo false;
        }

    }

}