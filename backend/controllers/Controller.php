<?php

/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 16/8/24
 * Time: 下午3:23
 */
namespace backend\controllers;

use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            // 后台必须登录才能使用
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}