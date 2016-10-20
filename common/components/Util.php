<?php

/**
 *工具类
 */
class Util {

    /**
     *
     * 产生随机字符串，不长于32位
     */
    public static function getNonceStr($length = 32) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }


    /**
     * 直接输出xml
     * @param string $xml
     */
    public static function replyNotify($xml) {
        echo $xml;
    }

    /**
     * 获取毫秒级别的时间戳
     */
    public static function getMillisecond() {
        //获取毫秒的时间戳
        $time = explode(" ", microtime());
        $time2 = explode(".", $time[0]);
        $time = $time[1] . substr($time2[1], 0, 3);
        return $time;
    }


    public static function format($format) {
        $args = func_get_args();
        $format = array_shift($args);

        preg_match_all('/(?=\{)\{(\d+)\}(?!\})/', $format, $matches, PREG_OFFSET_CAPTURE);
        $offset = 0;
        foreach ($matches[1] as $data) {
            $i = $data[0];
            $format = substr_replace($format, @$args[$i], $offset + $data[1] - 1, 2 + strlen($i));
            $offset += strlen(@$args[$i]) - 2 - strlen($i);
        }
        return $format;
    }

    //生成提车码或者优惠券码
    public static function getRandChar() {
        $time = time();
        $ip = Yii::$app->request->userIP;
        $ip = str_replace('.','',$ip);
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < 8; $i++) {
            $str .= $strPol[rand(0, $max)];
        }
        $randOne = $str;
        $randTwo = MD5($time . $ip . $randOne);
        $randThree = substr($randTwo,1,4) . substr($randTwo,-4);

        //date_default_timezone_set("Asia/Shanghai");
        // $str = $str . date("YmdHis");

        return strtoupper($randThree);
    }

    //生成显示订单号
    public static function getOrderId() {
        $time = explode(" ", microtime());
        $time2 = explode(".", $time[0]);
        $time = $time[1] . substr($time2[1], 0, 3);
        $randNum = rand(100, 999);
        return intval($time . $randNum);
    }
}

