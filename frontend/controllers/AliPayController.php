<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 2016/11/11 0011
 * Time: 10:14
 */
namespace frontend\controllers;

use common\components\AliPay;
use common\models\Order;
use yii\log\Logger;

class AliPayController extends BaseController {

    /**
     * 支付宝支付页面
     * @return array
     */
    public function actionPay() {
        header("Content-type:text/html;charset=utf-8");

        $orderId = \Yii::$app->request->get('orderId');
        if (!isset($orderId)) {
            return $this->renderJson(['success' => false, 'message' => '订单号不能为空.', 'data' => []]);
        }

        // 判定订单是否合理
        $checkOrder = Order::checkPayable($orderId);
        if (!$checkOrder['success']) {
            return $checkOrder;
        }
        //获取订单中的信息
       // $model = Order::findOne($orderId);
        //$formInfoId = $model->form_info_id;
        $order = Order::getOrderDetailInfo($orderId);
        if (!$order['success']) {
           return $this->renderJson(['success' => false, 'message' => $order['message'], 'data' => []]);

        }
        $subject = $order['data']['subject'];
        //$amount = $order['data']['amount'] / 100;
        //从订单中加上时间限制
        $extra = json_decode($order['data']['extra'], true);
        $orderStartTime = $order['data']['createdTime'];


        //从订单中读取订单过期时间，如果读不到 则在订单创建时间上加1天
        $orderExpireTime = isset($extra['overdue_time']) ? intval($extra['overdue_time']) : $orderStartTime + 86400;
        //支付单失效时间为订单失效时间之前的60秒
        $paymentExpireTime = $orderExpireTime - 60;
        $deposit = $extra['deposit'] / 100;
        $logData = [
            'orderId' => $orderId,
            'subject' => $subject,
            'deposit' => $deposit,
            'paymentExpireTime' => $paymentExpireTime
        ];
        \Yii::getLogger()->log("ali-pay pay ************************** " . print_r($logData, true),
            Logger::LEVEL_INFO);

        $url = AliPay::addOrder($orderId, $subject, $deposit, $paymentExpireTime);
        $this->redirect($url);
    }

    /**
     * 支付宝支付结果回调接口
     *
     */
    public function actionNotify() {
        try {
            $notifyId = $_REQUEST['notify_id'];
            \Yii::getLogger()->log("ali-pay notify ************************** " . $notifyId, Logger::LEVEL_INFO);

            if (AliPay::checkNotify($notifyId)) {
                $tradeStatus = $_REQUEST['trade_status'] == 'TRADE_SUCCESS';
                $outTradeNo = $_REQUEST['out_trade_no'];
                $orderId = substr($outTradeNo, strlen(\Yii::$app->params['env']) + 1);
                $tradeNo = $_REQUEST['trade_no'];

                if ($tradeStatus) {
                    $ret = Order::updatePaymentStatus($orderId, Order::ALIPAY_MOBILE, Order::PAYMENT_STATUS_SUCCESS,
                        $tradeNo);
                } else {
                    $ret = Order::updatePaymentStatus($orderId, Order::ALIPAY_MOBILE, Order::PAYMENT_STATUS_FAILED,
                        $tradeNo);
                }

                $logData = [
                    'tradeStatus' => $tradeStatus,
                    'outTradeNo' => $outTradeNo,
                    'orderId' => $orderId,
                    'tradeNo' => $tradeNo,
                    'ret' => $ret
                ];
                \Yii::getLogger()->log("ali-pay notify ************************** " . print_r($logData, true),
                    Logger::LEVEL_INFO);

                return "success";
            } else {
                return "fail";
            }
        } catch (Exception $e) {
            \Yii::getLogger()->log("ali-pay notify fail " . print_r($_REQUEST, true),
                Logger::LEVEL_ERROR);
            return "fail";
        }
    }

    /**
     * 支付成功承接页
     *
     */
    public function actionResult() {
        $outTradeNo = $_REQUEST['out_trade_no'];
        \Yii::getLogger()->log("ali-pay result ************************** out_trade_no: " .
            $outTradeNo, Logger::LEVEL_INFO);
        $orderId = substr($outTradeNo, strlen(\Yii::$app->params['env']) + 1);
        \Yii::getLogger()->log("ali-pay result ************************** orderId: " .
            $orderId, Logger::LEVEL_INFO);
        $this->redirect(array('/order/detail', 'orderId' => $orderId));
    }

}