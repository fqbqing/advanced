<?php

/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 16/4/26
 * Time: 下午5:07
 */
namespace common\components\helpers;

trait FindCountTrait
{
    // 返回数量
    public static function findCount($condition, $q = '*')
    {
        return static::findByCondition($condition)->count($q);
    }

}