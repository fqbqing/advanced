<?php
/**
 * Created by PhpStorm.
 * User: yappy
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
}