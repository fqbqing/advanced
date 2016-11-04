<?php
namespace common\components\helpers;

use common\models\SmsLog;
use yii;

/**
 * 添加在components目录下的助手函数
 * Class TestHelper
 */
class PublicHelper
{


    /**
     * 设置过期时间和返回手机接收码
     * @param $length
     * @return null|string
     */
    public static function hidtel($phone)
    {
        //屏蔽电话号码中间的四位数字
        $IsWhat = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i', $phone); //固定电话
        if ($IsWhat == 1) {
            return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i', '$1****$2', $phone);

        } else {
            return preg_replace('/(1[358]{1}[0-9])[0-9]{4}([0-9]{4})/i', '$1****$2', $phone);
        }

    }

    /**
     *
     * 产生随机字符串，不长于32位
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public static function hidcard($str)
    {
        return substr_replace($str,str_repeat('*',6), 6, 8);
    }
    /**
     * 校验日期格式是否正确
     * @param string $date 日期
     * @param string $formats 需要检验的格式数组
     * @return boolean
     */
    public static function checkDateIsValid($date, $formats = array("Y-m-d", "Y/m/d")) {
        $unixTime = strtotime($date);
        if (!$unixTime) { //strtotime转换不对，日期格式显然不对。
            return false;
        }
        //校验日期的有效性，只要满足其中一个格式就OK
        foreach ($formats as $format) {
            if (date($format, $unixTime) == $date) {
                return true;
            }
        }
        return false;
    }

}