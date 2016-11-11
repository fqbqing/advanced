<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 2016/11/11 0011
 * Time: 10:14
 */
namespace frontend\controllers;

use dosamigos\qrcode\QrCode;
use dosamigos\qrcode\lib\Enum;
use yii\log\Logger;
use Yii;
use common\components\WeixinPay;
use common\models\Order;
use yii\helpers\Url;


class WeixinPayController extends BaseController {


    /**
     * 响应微信支付通知的回调接口
     * @return string
     */
    public function actionNotify() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        //校验合法性
        $notifyRet = WeixinPay::parseNotify();
        $notify = $notifyRet['data']['notify'];
        //更新订单状态
        if (isset($notify['result_code']) && isset($notify['out_trade_no']) && isset($notify['transaction_id'])
            && isset($notify['trade_type'])
        ) {
            $tmp = explode('_', $notify['out_trade_no']);
            $count = count($tmp);
            $orderId = intval($tmp[$count - 1]);
            //支付方式（微信扫码还是微信原生）
            $payment = ($notify['trade_type'] === 'JSAPI') ? Order::WEIXIN_NATIVE : Order::WEIXIN_SCAN;
            if ($notify['result_code'] === 'SUCCESS') {
                $ret = Order::updatePaymentStatus($orderId, $payment, Order::PAYMENT_STATUS_SUCCESS,
                    $notify['transaction_id']);
            } else if ($notify['result_code'] === 'FAIL') {
                $ret = Order::updatePaymentStatus($orderId, $payment, Order::PAYMENT_STATUS_FAILED,
                    $notify['transaction_id']);
            }
            Yii::getLogger()->log('Update status, response from order:' . json_encode($ret),
                Logger::LEVEL_INFO);
        }
        return $notifyRet['data']['result'];
    }

    public function actionQrcode() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $text = \Yii::$app->request->get('text');
        return QrCode::png($text, false, Enum::QR_ECLEVEL_L, 6, 0);   //6为二维码大小, 0为边框
    }

    /**
     * 微信支付页面
     * @return array
     */
    public function actionPay() {
        $isInWeixin = $this->isInWeixin();
        return $this->renderPartial('pay', ['isInWeixin' => $isInWeixin]);
    }

    /**
     * 创建微信扫码支付，请求微信并返回二维码链接
     * @return array
     */
    public function actionCreatePayment() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $ret = [];
        $orderId = \Yii::$app->request->get('orderId');
        if (!isset($orderId)) {
            return ['success' => false, 'message' => 'orderId cannot be blank.', 'data' => []];
        }
        //检查订单是否可支付
        $checkRet = Order::checkPayable($orderId);
        if (!$checkRet['success']) {
            return ['success' => false, 'message' => '该订单无法被支付。', 'data' => []];
        }
        //获取订单中的信息

        $order = Order::getOrderDetailInfo($orderId);
        if (!$order['success']) {
            $ret = ['success' => false, 'message' => $order['message'], 'data' => []];
        }

        $subject = $order['data']['subject'];
        //$amount = $order['data']['amount'];
        //从订单中加上时间限制
        $extra = json_decode($order['data']['extra'], true);
        $orderStartTime = $order['data']['createdTime'];
        //从订单中读取订单过期时间，如果读不到 则在订单创建时间上加1天
        $orderExpireTime = isset($extra['overdue_time']) ? intval($extra['overdue_time']) : $orderStartTime + 86400;
        //支付单失效时间为订单失效时间之前的5秒
        $paymentExpireTime = $orderExpireTime - 5;
        $deposit = $extra['deposit'];
        $isInWeixin = $this->isInWeixin();
        $weixinRet = WeixinPay::createOrder($orderId, $subject, $deposit, $paymentExpireTime, $isInWeixin);
        if ($isInWeixin) {
            if ($weixinRet['success']) {
                $ret = ['success' => true, 'message' => '', 'data' => $weixinRet['data']];
            } else {
                $ret = ['success' => false, 'message' => $weixinRet['message'], 'data' => []];
            }
        } else {
            if (isset($weixinRet['result_code']) && $weixinRet['result_code'] === 'SUCCESS') {
                $ret = ['success' => true, 'message' => '', 'data' => [
                    'orderId' => $orderId,
                    'image' => Url::toRoute('weixin-pay/qrcode') . '?text=' . urlencode($weixinRet['code_url']),
                    'deposit' => $deposit
                ]];
            } else {
                $ret = ['success' => false, 'message' => isset($weixinRet['err_code_des']) ?
                    $weixinRet['err_code_des'] : $weixinRet['return_msg'], 'data' => []];
            }
        }

        return $ret;

    }
}