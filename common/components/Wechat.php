<?php

/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 16/5/4
 * Time: 下午6:48
 */
namespace common\components;

class Wechat
{

    public  $appId;
    public  $appSecret;
    public  $apiUrl;

    public function __construct($appId,$appSecret,$apiUrl)
    {
        $this->appId=$appId;
        $this->appSecret=$appSecret;
        $this->apiUrl=$apiUrl;
    }

    private function __CreateOauthUrlForCode($redirectUrl)
    {

        $urlObj["appid"] = $this->appId;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE" . "#wechat_redirect";
        $bizString = self::ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?" . $bizString;
    }

    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return 返回已经拼接好的字符串
     */
    private static function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            if ($k != "sign") {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);//$this->curl_timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        $data = json_decode($res, true);
        return $data['openid'];
    }

    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code ，微信跳转带回的code
     *
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {

        $urlObj["appid"] = $this->appId;
        $urlObj["secret"] = $this->appSecret;
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?" . $bizString;
    }

    /**
     * 获取用户openid
     * @return null|\用户的openid
     */
    public function getWeixinOpenId()
    {
        //通过code获得openid
        if (!isset($_GET['code'])) {
            //触发微信返回code码
            $proxy =  $this->apiUrl. "/proxy.php?u=%s";
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $baseUrl = urlencode($url);
            $proxyUrl = urlencode(sprintf($proxy, $baseUrl));
            $url = $this->__CreateOauthUrlForCode($proxyUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $openid = $this->getOpenidFromMp($code);
            return $openid;
        }
    }

}
/*$appId='wxdceb099af1f59d5d';
$appSecret='52104e58657b7da504158cbd4d1279a7';
$apiUrl='http://dev-api.zhanqu.im';

$weixin = new Weixin($appId,$appSecret,$apiUrl);
$openId = $weixin->getWeixinOpenId();
echo '<pre>';
var_dump( $openId );
echo '</pre>';
exit;*/