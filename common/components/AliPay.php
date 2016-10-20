<?php

require_once __DIR__ . "/alipay/alipay_submit.class.php";
require_once __DIR__ . "/alipay/alipay_notify.class.php";
require_once __DIR__ . "/alipay/alipay_core.function.php";
require_once __DIR__ . "/alipay/alipay_rsa.function.php";
require_once __DIR__ . "/Util.php";
require_once __DIR__ . "/MobileDetect.php";
require_once __DIR__ . "/MobileDetect.php";


class AliPay {

    public static $partner='2088411945226741';
    public static $sellerEmail='2858932098@qq.com';
    public static $key='cau8o29wko4khkffe42zld61vmpenyqk';
   // public static $service;
   // public static $isMobile = false;

    // 新建支付订单
    public static function addOrder($orderId, $name, $price, $endTime = 0, $notifyUrl = '', $returnUrl = '') {
        $alipaySubmit = self::getAlipaySubmit($notifyUrl, $returnUrl);
        $orderId = 'test' . '_' . $orderId;
        $param = self::buildParam($orderId, $name, $price, $endTime, $notifyUrl, $returnUrl);
        return $alipaySubmit->alipay_gateway_new . $alipaySubmit->buildRequestParaToString($param);
    }

    private static function buildParam($orderId, $name, $price, $endTime = 0, $notifyUrl = '', $returnUrl = '') {
        // 设置必填信息
        $parameter = [
            'out_trade_no' => $orderId,
            'subject' => $name,
            'total_fee' => ceil($price * 100) / 100,
            'partner' => self::$partner,

        ];
        //手机端支付参数不一样

        if (\MobileDetect::isMobile()) {
            $parameter['seller_id'] = self::$sellerEmail;
            $parameter['service'] = 'alipay.wap.create.direct.pay.by.user';//wap

        } else {
            $parameter['seller_email'] = self::$sellerEmail;
            $parameter['service'] = 'create_direct_pay_by_user';//pc
        }
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
            '_input_charset' => 'utf-8',
            'payment_type' => '1',
            'notify_url' => $notifyUrl,
            'return_url' => $returnUrl
        ];

        return $parameter;

    }

    // 新建退款
    public static function refund($orders) {
        $details = "";
        $refundReason = '协商退款';
        $batchNum = count($orders);
        foreach ($orders as $order) {
            if (!isset($order['order_id']) || !isset($order['amount']) || !isset($order['serials_number'])) {
                return ['success' => false, 'message' => 'Invalid orders.'];
            }
            $serialsNumber = $order['serials_number'];
            $amount = $order['amount'] / 100;
            $details .= self::createRefundDetail($serialsNumber, $amount, $refundReason);
        }
        //去掉最后一个#字符
        $detailData = substr($details, 0, count($details) - 2);

        return self::postRefund($batchNum, $detailData);
    }

    public static function postRefund($batchNum, $detailData, $notifyUrl = '') {
        if (empty($notifyUrl)) {
            $notifyUrl = '/api/tuan-order/refund-notify';
        }

        $parameter = array(
            "service" => "refund_fastpay_by_platform_pwd",
            "partner" => \Yii::$app->params['alipay.partner'],
            "notify_url" => \Yii::$app->request->hostInfo . $notifyUrl,
            "seller_email" => \Yii::$app->params['alipay.seller'],
            "refund_date" => date('Y-m-d H:i:s', time()),
            "batch_no" => date('Ymd') . Util::getNonceStr(24),
            "batch_num" => $batchNum,
            "detail_data" => $detailData,
            "_input_charset" => Yii::$app->params['alipay.charset']
        );
        $signParameter = self::getSignParameter($parameter);

        return self::createUrl($signParameter);
    }

    private static function createUrl($signParameter) {
        $url = 'https://mapi.alipay.com/gateway.do?';
        foreach ($signParameter as $key => $value) {
            $url .= $key . '=' . urlencode($value) . '&';
        }
        $url = substr($url, 0, count($url) - 2);
        return $url;

    }

    private static function getSignParameter($parameter) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($parameter);

        //对待签名参数数组排序
        $para_sort = argSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);

        //签名
        $sign = rsaSign($prestr, __DIR__ . '/alipay/key/rsa_private_key.pem');
        $parameter['sign'] = $sign;
        $parameter['sign_type'] = 'RSA';
        return $parameter;
    }

    private static function createRefundDetail($serialsNumber, $amount, $refundReason) {
        $arg = "";
        $arg .= $serialsNumber . "^" . $amount . "^" . $refundReason . "#";
        return $arg;
    }

    public static function parseRefundDetail($detailData) {
        $parseDetails = array();
        $details = explode('#', $detailData);
        foreach ($details as $detail) {
            $ret = explode('^', $detail);
            if ($ret[2] !== 'SUCCESS' && !strstr($ret[2], '$$')) {
                return ['success' => false, 'message' => 'detail_data invalid.'];
            }
            $parseDetails[$ret[0]] = $ret[1];
        }
        return ['success' => true, 'data' => $parseDetails];
    }

    public static function signVerify($parameter, $sign) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($parameter);

        //对待签名参数数组排序
        $para_sort = argSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);
        Yii::getLogger()->log('RefundNotify-待签名参数:' . $prestr, Logger::LEVEL_INFO);

        return rsaVerify($prestr, __DIR__ . '/alipay/key/alipay_public_key.pem', $sign);
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
            'partner' => self::$partner,
            'seller_id' => self::$sellerEmail,
            'private_key_path' => $libraryPath . '/key/rsa_private_key.pem',
            'ali_public_key_path' => $libraryPath . '/key/alipay_public_key.pem',
            'sign_type' => 'RSA',
            'input_charset' => 'utf-8',
            'cacert' => $libraryPath . '/key/cacert.pem',
            'transport' => 'http',
            'notify_url' => $notifyUrl,
            'return_url' => $returnUrl
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
            'partner' => self::$partner,
            'notify_id' => $notifyId // 此处 !不能! 用urlencode
        ]) : false;

        return $result;
    }


}

//开始支付测试
$aliPayUrl = AliPay::addOrder($oderId='3T1471796009108742N1','测试alipay支付','0.01');
header("Location: $aliPayUrl");
//test.dev.com/alipay/AliPay.php
