<?php

/**
 * Created by PhpStorm.
 * User: Wang Zhaogang
 * Date: 2015/12/14
 * Time: 12:11
 */

namespace app\components;


require_once __DIR__ . "/wxpay/WxPay.Api.php";
require_once __DIR__ . "/wxpay/WxPay.JsApiPay.php";
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\log\Logger;
use app\models\Order;
use app\models\User;

/**
 * Class WeixinPay
 * @package app\components
 */
class WeixinPay {


    /**
     * 创建微信支付单
     * @param $orderId
     * @param $productId
     * @param $name
     * @param $deposit
     * @param $expireTime
     * @param bool|false $isInWeixin
     * @return array|\成功时返回
     * @throws \WxPayException
     */
    public static function createOrder($orderId, $productId, $name, $deposit, $expireTime, $isInWeixin = false,
                                       $notifyUrl = '') {

        $input = new \WxPayUnifiedOrder();
        $input->SetAppid(Yii::$app->params['weixin.appId']);
        $input->SetMch_id(Yii::$app->params['weixin.mchId']);
        $input->SetDevice_info("WEB");
        $input->SetBody($name);
        $input->SetTime_start(date('YmdHis', time()));
        $input->SetTime_expire(date('YmdHis', $expireTime));
        Yii::getLogger()->log('Weixinpay order created, time:' . json_encode(['s' => $input->GetTime_start(),
                'e' => $input->GetTime_expire()]),
            Logger::LEVEL_INFO);
        $input->SetTotal_fee($deposit);
        if ($isInWeixin) {
            $input->SetTrade_type('JSAPI');
            //获取并设置用户openId
            $userId = Yii::$app->user->getIdentity()->getId();
            $user = User::findOne($userId);
            $input->SetOpenid($user->getOpenId());
            $input->SetOut_trade_no(Yii::$app->params['weixin.jsapi_orderIdPrefix'] . $orderId);
        } else {
            $input->SetTrade_type('NATIVE');
            $input->SetOut_trade_no(Yii::$app->params['weixin.scan_orderIdPrefix'] . $orderId);
        }

        $input->SetProduct_id($productId);

        if (empty($notifyUrl)) {
            $notifyUrl = 'weixin-pay/notify';
        }
        $input->SetNotify_url(Url::toRoute($notifyUrl, true));

        $order = \WxPayApi::unifiedOrder($input);

        if ($isInWeixin) {
            $jsApi = new \JsApiPay();
            try {
                $ret = ['success' => true, 'data' => json_decode($jsApi->GetJsApiParameters($order))];
            } catch (\WxPayException $e) {
                Yii::getLogger()->log('weixin jsapi order failed.' . json_encode($order),
                    Logger::LEVEL_INFO);
                $ret = ['success' => false, 'message' => isset($order['err_code_des']) ? $order['err_code_des']
                    : $order['return_msg']];
            }

        } else {
            $ret = $order;
        }
        Yii::getLogger()->log('Weixinpay order created, response from weixin:' . json_encode($order),
            Logger::LEVEL_INFO);
        return $ret;
    }

    /**
     * 解析微信通知回调
     * @param array $args
     * @return array|string
     * @throws \WxPayException
     */
    public static function parseNotify($args = []) {
        $notify = new \WxPayNotifyReply();
        //只允许POST请求
        if (!Yii::$app->request->isPost) {
            $notify->SetReturn_code('FAIL');
            $notify->SetReturn_msg('POST Only');
            return $notify->toXml();
        }
        Yii::getLogger()->log($GLOBALS['HTTP_RAW_POST_DATA'], Logger::LEVEL_TRACE);

        $message = '';
        $result = \WxPayApi::notify(function ($data) {
            return $data;
        }, $message);
        Yii::getLogger()->log('Weixinpay order notified, response from weixin:' . json_encode($result),
            Logger::LEVEL_INFO);
        if (!$result) {
            $args['message'] = $message;
            Yii::getLogger()->log('Invalid weixinpay notify: ' . $message . ' REQUEST:' . $GLOBALS['HTTP_RAW_POST_DATA'], Logger::LEVEL_WARNING);
            $notify->SetReturn_code('FAIL');
            $notify->SetReturn_msg($message);
        } else {
            $notify->SetReturn_code('SUCCESS');
            $notify->SetReturn_msg('OK');
            //订单逻辑
        }
        return ['success' => true, 'data' => ['result' => $notify->toXml(), 'notify' => $result]];
    }

    /**
     * 获取用户openid
     * @return null|\用户的openid
     */
    public static function getWeixinOpenId() {
        try {
            $jsApi = new \JsApiPay();
            return $jsApi->GetOpenid();
        } catch (Exception $e) {
            Yii::getLogger()->log('Get weixin openId failed. :' . $e->getMessage(),
                Logger::LEVEL_INFO);
            return null;
        }
    }

    /**
     * 退款申请
     * @param $orderId  订单id
     * @param $payment  支付方式
     * @param $deposit  退款金额
     */
    public static function refund($orderId, $payment, $deposit) {
        $input = new \WxPayRefund();
        $input->SetAppid(Yii::$app->params['weixin.appId']);
        $input->SetMch_id(Yii::$app->params['weixin.mchId']);
        if ($payment === Order::WEIXIN_NATIVE) {
            $tradeNo = Yii::$app->params['weixin.jsapi_orderIdPrefix'] . $orderId;
        } else if ($payment === Order::WEIXIN_SCAN) {
            $tradeNo = Yii::$app->params['weixin.scan_orderIdPrefix'] . $orderId;
        }
        $input->SetOut_trade_no($tradeNo);
        $input->SetOut_refund_no($tradeNo);
        $input->SetTotal_fee($deposit);
        $input->SetRefund_fee($deposit);
        $input->SetOp_user_id(Yii::$app->params['weixin.mchId']);

        $refund = \WxPayApi::refund($input);
        Yii::getLogger()->log('Weixinpay refund created, response from weixin:' . json_encode($refund),
            Logger::LEVEL_INFO);

        if (isset($refund['result_code']) && $refund['result_code'] === 'SUCCESS'){
            return ['success' => true, 'data' => 'success'];
        }
        return ['success' => false,'message' => isset($refund['err_code_des']) ? $refund['err_code_des'] : $refund['return_msg']];
    }

    /**
     * 退款查询
     * @param $orderId
     * @param $payment
     * @return \成功时返回
     * @throws \WxPayException
     */
    public static function refundQuery($orderId, $payment) {
        $input = new \WxPayRefundQuery();
        $input->SetAppid(Yii::$app->params['weixin.appId']);
        $input->SetMch_id(Yii::$app->params['weixin.mchId']);
        $tradeNo = "";
        if ((int)$payment === Order::WEIXIN_NATIVE) {
            $tradeNo = Yii::$app->params['weixin.jsapi_orderIdPrefix'] . $orderId;
        }  if ((int)$payment === Order::WEIXIN_SCAN) {
            $tradeNo = Yii::$app->params['weixin.scan_orderIdPrefix'] . $orderId;
        }
        $input->SetOut_refund_no($tradeNo);

        $refundQuery = \WxPayApi::refundQuery($input);
        Yii::getLogger()->log('Weixinpay refund query, response from weixin:' . json_encode($refundQuery),
            Logger::LEVEL_INFO);
        return (isset($refundQuery['result_code']) && $refundQuery['result_code'] === 'SUCCESS')
            ? ['success' => true, 'data' => isset($refundQuery['refund_status_0']) ? $refundQuery['refund_status_0'] : '']
            : ['success' => false, isset($refundQuery['err_code_des']) ? $refundQuery['err_code_des']
                : $refundQuery['return_msg']];
    }
}
