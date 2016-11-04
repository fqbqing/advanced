<?php

/**
 * Created by PhpStorm.
 * User: AQi
 * Date: 2016/10/20 0020
 * Time: 18:46
 */
namespace console\controllers;
use yii\console\Controller;
class TestController extends Controller
{
    public function actionIndex()
    {
        $cash = 40;
        $user_arr = array(6,6,6,6,6,6,6,6,6,6);
        while($cash>0){
            $user_id = rand(0, 9);
            if($user_arr[$user_id]<12){
                $user_arr[$user_id]++;
                $cash--;
            }
        }

        ;
        var_dump($user_arr,array_sum($user_arr));die;
    }

    /**
     * 计算下一月日期/截至今天为止.超过今天从上一月算起
     */
    public function actionNextInterval()
    {

        $items = \common\components\helpers\DateHelper::getMonthPeriod();
        echo '<pre>';
        var_dump( $items );
        echo '</pre>';
        exit;
        return;
    }


}