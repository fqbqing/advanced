<?php

namespace app\components;


class Weixin {

    const KEY_ACCESS_TOKEN = 'cms_weixin_access_token';
    const KEY_JSAPI_TICKET = 'cms_weixin_jsapi_ticket';

    /**
     * 检查用户是否关注公众号
     *
     * @param  string $openId
     * @return bool
     */
    public static function checkSubscribe($openId) {
        $userInfo = self::getUserInfo($openId);
        if (!isset($userInfo) || empty($userInfo)) {
            return false;
        }
        return !!$userInfo['subscribe'];
    }

    /**
     * 获取微信用户信息
     *
     * @param  string $openId
     * @return array
     */
    public static function getUserInfo($openId) {
        $accessToken = self::getAccessToken();
        if (!isset($accessToken)) {
            return null;
        }

        return self::request('https://api.weixin.qq.com/cgi-bin/user/info', [
            'access_token' => $accessToken,
            'openid' => $openId,
            'lang' => 'zh_CN'
        ]);
    }

    /**
     * 获取微信Access Token
     *
     * @return string
     */
    private static function getAccessToken() {
        // 优先从缓存读取
        $accessToken = self::get();

        // 没有的话从接口获取，并存入缓存
        if (!isset($accessToken)) {
            $result = self::request('https://api.weixin.qq.com/cgi-bin/token', [
                'grant_type' => 'client_credential',
                'appid' => \Yii::$app->params['weixin.appId'],
                'secret' => \Yii::$app->params['weixin.app_secret']
            ]);

            if (!isset($result) || empty($result)) {
                \Yii::getLogger()->log("get access-token fail", \yii\log\Logger::LEVEL_ERROR);
            }

            $accessToken = $result['access_token'];
            $expires = round($result['expires_in'] * 0.95); // 单位：秒，对微信提供的缓存时间*0.95，留一点余地
            self::save($accessToken, $expires);
        }

        return $accessToken;
    }
    /**
     * 获取微信参数
     *
     * @return string
     */
    public static function getJsParams($jsApiList, $url = null) {
        $timestamp = time();
        $nonceStr = self::getNonceStr();

        return [
            'appId' => \Yii::$app->params['weixin.appId'],
            'timestamp' => $timestamp,
            'nonceStr' => $nonceStr,
            'signature' => self::signature($nonceStr, $timestamp, $url),
            'jsApiList' => $jsApiList,
        ];
    }
    /**
     * 生成随机字符串
     *
     * @param int $length
     * @return string
     */
    private static  function getNonceStr($length = 16) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    /**
     * 参数签名
     *
     * @param  $nonceStr  string
     * @param  $timestamp number
     * @return string
     */
    private static function signature($nonceStr, $timestamp, $url = null) {
        $jsTicket = self::getJsapiTicket();
        //$url = URL::full();
        if (!isset($url)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
        $str = "jsapi_ticket={$jsTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url=$url";

        return sha1($str);
    }
    /**
     * 获取微信Jsapi Ticket
     *
     * @return string
     */
    private static function getJsapiTicket() {
        // 优先从缓存读取
        $jsapiTicket = self::get(self::KEY_JSAPI_TICKET);

        // 没有的话从接口获取，并存入缓存

        if (!isset($jsapiTicket)) {
            $result = self::request('https://api.weixin.qq.com/cgi-bin/ticket/getticket', [
                'access_token' => self::getAccessToken(),
                'type' => 'jsapi',
            ]);

            if (!isset($result) || empty($result)) {
                \Yii::getLogger()->log("get jsapi ticket fail", \yii\log\Logger::LEVEL_ERROR);
            }

            $jsapiTicket = $result['ticket'];
            $expires = round($result['expires_in'] * 0.95); // 单位：秒，对微信提供的缓存时间*0.95，留一点余地
            self::save($jsapiTicket, $expires, self::KEY_JSAPI_TICKET);
        }

        return $jsapiTicket;
    }

    /**
     * 向微信发起请求
     *
     * @param string $url
     * @param array $param
     * @param bool|FALSE $post
     * @return mixed
     */
    private static function request($url, $param = [], $post = false) {
        $result = RequestUtil::request($url, $param, $post);
        $logData = [
            'url' => $url,
            'params' => $param,
            'post' => $post
        ];

        if ($result['success'] != true) {
            $data = $result['msg'];
            $logData['ret'] = '请求微信接口失败, 错误信息为[' . $data . ']';
            \Yii::getLogger()->log(print_r($logData, true), \yii\log\Logger::LEVEL_ERROR);
            return array();
        }

        $data = $result['data'];
        $data = json_decode($data, true);
        if (isset($data['errcode']) && intval($data['errcode']) > 0) {
            $error = $data['errmsg'];
            $logData['ret'] = '请求微信接口失败, 错误信息为[' . $error . ']';
            \Yii::getLogger()->log(print_r($logData, true), \yii\log\Logger::LEVEL_ERROR);
            return array();
        }

        return $data;
    }

    /**
     * 把数据写入缓存中
     *
     * @param string $accessToken
     * @param string $deadline
     */
    private static function save($accessToken, $deadline = 0, $key = self::KEY_ACCESS_TOKEN) {
        $deadline = $deadline ? $deadline : 3600;
        \Yii::$app->redis->setex($key, $deadline, $accessToken);
    }

    /**
     * 从缓存中读数据
     *
     * @return mixed
     */
    private static function get($key = self::KEY_ACCESS_TOKEN) {
        return \Yii::$app->redis->get($key);
    }

}
