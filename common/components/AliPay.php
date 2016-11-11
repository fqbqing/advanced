<?php

namespace common\components;

use Yii;

require_once __DIR__ . "/alipay/alipay_submit.class.php";
require_once __DIR__ . "/alipay/alipay_notify.class.php";


class AliPay {

    // 新建支付订单
    public static function addOrder($orderId, $name, $price, $endTime = 0, $notifyUrl = '', $returnUrl = '') {
        $alipaySubmit = self::getAlipaySubmit($notifyUrl, $returnUrl);
        $orderId = \Yii::$app->params['env'] . '_' . $orderId;
        $param = self::buildParam($orderId, $name, $price, $endTime, $notifyUrl, $returnUrl);
        return $alipaySubmit->alipay_gateway_new . $alipaySubmit->buildRequestParaToString($param);
    }

    private static function buildParam($orderId, $name, $price, $endTime = 0, $notifyUrl = '', $returnUrl = '') {
        // 设置必填信息
        $parameter = [
            'out_trade_no' => $orderId,
            'subject' => $name,
            'total_fee' => ceil($price * 100) / 100
        ];

        // 选填参数映射表
        $map = array(
            'detail' => 'body',
            'url' => 'show_url',
        );

        if ($endTime > 0) {
            $parameter['it_b_pay'] = date('Y-m-d H:i:s', $endTime);
        }

        if (empty($notifyUrl)) {
            $notifyUrl = '/ali-pay/notify';
        }
        if (empty($returnUrl)) {
            $returnUrl = '/ali-pay/result';
        }

        $parameter += [
            'service' => 'alipay.wap.create.direct.pay.by.user',
            '_input_charset' => Yii::$app->params['alipay.charset'],
            'payment_type' => '1',
            'partner' => \Yii::$app->params['alipay.partner'],
            'seller_id' => \Yii::$app->params['alipay.seller'],
            'notify_url' => \Yii::$app->request->hostInfo . $notifyUrl,
            'return_url' => \Yii::$app->request->hostInfo . $returnUrl
        ];

        return $parameter;

    }

    /**
     * 获取支付宝提交对象
     *
     * @return \AlipaySubmit
     */
    private static function getAlipaySubmit($notifyUrl = '', $returnUrl = '') {
        $libraryPath = __DIR__ . '/alipay';
        if (empty($notifyUrl)) {
            $notifyUrl = '/ali-pay/notify';
        }
        if (empty($returnUrl)) {
            $returnUrl = '/ali-pay/result';
        }

        $config = array(
            'partner' => Yii::$app->params['alipay.partner'],
            'seller_id' => Yii::$app->params['alipay.seller'],
            'private_key_path' => $libraryPath . '/key/rsa_private_key.pem',
            'ali_public_key_path' => $libraryPath . '/key/alipay_public_key.pem',
            'sign_type' => 'RSA',
            'input_charset' => 'utf-8',
            'cacert' => $libraryPath . '/key/cacert.pem',
            'transport' => 'http',
            'notify_url' => \Yii::$app->request->hostInfo . $notifyUrl,
            'return_url' => \Yii::$app->request->hostInfo . $returnUrl
        );
        return new \AlipaySubmit($config);
    }

    /**
     * 检查通知合法性
     *
     * @param  string $notifyId
     * @return bool
     */
    public static function checkNotify($notifyId) {

        $url = 'https://mapi.alipay.com/gateway.do';

        $result = $notifyId ? $result = RequestUtil::request($url, [
            'service' => 'notify_verify',
            'partner' => Yii::$app->params['alipay.partner'],
            'notify_id' => $notifyId // 此处 !不能! 用urlencode
        ]) : false;

        return $result;
    }

}
