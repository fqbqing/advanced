<?php
namespace common\components;

require_once __DIR__ . "/wxpay/WxPay.Api.php";
require_once __DIR__ . "/wxpay/WxPay.JsApiPay.php";
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\log\Logger;


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
    public static function createOrder($orderId, $subject, $deposit, $expireTime, $isInWeixin = false,
                                       $notifyUrl = '') {
        $input = new \WxPayUnifiedOrder();
        $input->SetAppid(Yii::$app->params['weixin.appId']);
        $input->SetMch_id(Yii::$app->params['weixin.mchId']);
        $input->SetDevice_info("WEB");
        $input->SetBody($subject);
        $input->SetTime_start(date('YmdHis', time()));
        $input->SetTime_expire(date('YmdHis', $expireTime));
        Yii::getLogger()->log('Weixinpay order created, time:' . json_encode(['s' => $input->GetTime_start(),
                'e' => $input->GetTime_expire()]),
            Logger::LEVEL_INFO);
        $input->SetTotal_fee($deposit);
        if ($isInWeixin) {
            $input->SetTrade_type('JSAPI');
            //获取并设置用户openId
            $tools = new \JsApiPay();
            $openid = $tools->GetOpenid();
            $input->SetOpenid($openid);
            $input->SetOut_trade_no(Yii::$app->params['weixin.jsapi_orderIdPrefix'] . $orderId);
        } else {
            $input->SetTrade_type('NATIVE');
            $input->SetOut_trade_no(Yii::$app->params['weixin.scan_orderIdPrefix'] . $orderId);
        }

        $input->SetProduct_id($orderId);

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
}
