<?php

namespace common\models;

use common\service\PubService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\log\Logger;


class Order extends \yii\db\ActiveRecord
{
    //订单状态 对应订单表中的status
    /**
     * 正常(待付款)
     */
    const STATUS_NORMAL = 0;
    /**
     * 完成(已付款)
     */
    const STATUS_COMPLETED = 1;
    /**
     * 取消
     */
    const STATUS_CANCELED = 2;
    /**
     * 系统自动取消
     */
    const STATUS_SYSTEM_CANCELED = 3;
    /**
     * 申请退款
     */
    const STATUS_APPLY_FOR_REFUND = 4;
    /**
     * 退款成功
     */
    const STATUS_REFUND_SUCCESS = 5;

    //订单支付状态 对应订单表中的payment_status
    /**
     * 未支付
     */
    const PAYMENT_STATUS_NOT_PAY = 0;
    /**
     * 支付成功
     */
    const PAYMENT_STATUS_SUCCESS = 2;
    /**
     * 支付失败
     */
    const PAYMENT_STATUS_FAILED = 3;

    //订单支付方式 对应订单表中的payment
    /**
     * 微信扫码
     */
    const WEIXIN_SCAN = 1;
    /**
     * 微信原生
     */
    const WEIXIN_NATIVE = 2;
    /**
     * 支付宝手机端支付
     */
    const ALIPAY_MOBILE = 3;
    /**
     * 支付宝网页支付
     */
    const ALIPAY_WEB = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['exhibition_id','form_info_id', 'valid_status', 'order_id'], 'required'],
            [['form_info_id', 'exhibition_id', 'amount', 'payment', 'status', 'valid_status', 'payment_status'], 'integer'],
            [['description', 'extra'], 'string', 'max' => 512],
            [['order_id'], 'string', 'max' => 256],
        ];
    }

    public function getUser() {
        return $this->hasOne(WhFormInfo::className(), ['id' => 'form_info_id']);
    }

    /**
     * 判断订单能否被支付
     * @Param int orderId, int status
     * @return array
     */
    public static function checkPayable($orderId) {
        $order = Order::find()->andWhere(['order_id' => $orderId])->asArray()->one();
        if (!isset($order) || empty($order)) {
            return ['success' => false, 'message' => '找不到订单'];
        }

        $orderStatus = (int)$order['status'];
        $paymentStatus = (int)$order['payment_status'];
        if ($orderStatus !== self::STATUS_NORMAL || $paymentStatus === self::PAYMENT_STATUS_SUCCESS) {
            return ['success' => false, 'message' => '订单不能被支付'];
        }
        return ['success' => true];

    }
    /**
     * 查询订单详细信息
     * @Param Int orderId
     * @return array
     */
    public static function getOrderDetailInfo($orderId) {

        $model = Order::find()->andWhere(['order_id' => $orderId])->asArray()->one();
        if (!isset($model) || empty($model)) {
            return ['success' => false, 'message' => '找不到订单!'];
        }

        $extra = json_decode($model['extra'], true);
        $data = array();
        $data['orderId'] = $orderId;
        $data['status'] = $model['status'];
        $data['payment'] = $model['payment'];
        $data['createdTime'] = $model['created_at'];
        $data['extra'] = $model['extra'];

        $data['userInfo'] = array();
        $data['userInfo']['userName'] = $extra['user_name'];
        $data['userInfo']['userPhone'] = $extra['user_phone'];
        $data['subject'] = $extra['subject'];
        $data['deposit'] = $extra['deposit'];

        return ['success' => $data, 'data' => $data];
    }

    /**
     * 通知支付结果
     * @return array
     */
    public static function updatePaymentStatus($orderId, $payment, $paymentStatus, $tradeNo) {
        $order = Order::find()->andWhere(['order_id' => $orderId])->one();
        if (!isset($order) || empty($order)) {
            $message = '找不到订单。';
            self::orderLog('update_payment_status_error' . $message);
            return ['success' => false, 'message' => $message];
        }
        if ($paymentStatus != self::PAYMENT_STATUS_SUCCESS && $paymentStatus != self::PAYMENT_STATUS_FAILED) {
            $message = '参数paymentStatus不合法';
            self::orderLog('update_payment_status_error' . $message);
            return ['success' => false, 'message' => $message];
        }

        if ($order->status != self::STATUS_NORMAL || $order->payment_status == self::PAYMENT_STATUS_SUCCESS) {
            $message = '订单状态不能被改变';
            self::orderLog('update_payment_status_error' . $message);
            return ['success' => false, 'message' => $message];
        }
        $extra = json_decode($order['extra'], true);
        $connection = Yii::$app->db;
        //创建事务
        $transaction = $connection->beginTransaction();
        try {
            $order->payment = $payment;
            $order->payment_status = $paymentStatus;
            //票码
            $extra['seqnum'] = self::getNonceStr(10);
            $extra['trade_no'] = $tradeNo;
            $extra['payout_time'] = time();
            $extra['count_pay_success']=self::countPaySuccess()+1;
            $order->extra = json_encode($extra);
            if ( !$order->save()) {
                $transaction->rollBack();
                $message = 'mysql errors';
                self::orderLog('update_payment_status_error' . $message);
                return ['success' => false, 'message' => $message];
            }
            self::orderLog('update_payment_status' . json_encode($order->attributes));
            $transaction->commit();

            //为用户发发送票码
            $url=\yii::$app->params['getTicketUrl'] . $extra['seqnum'] . '&exhibitionId=' . $order->exhibition_id;
            $data = self::getOrderDetailInfo($orderId);
            $message='尊敬的'.$data['userInfo']['userName'].'，请点击链接获取您的“' . $data['subject']  . PubService::dwz($url) . ' ，请提前领取保存为图片，至展馆入口处扫码进场，请妥善保存。'. yii::$app->params['sms_signature'];
            $mobile = array(isset($extra['user_phone']) ? $extra['user_phone'] : '');
            PubService::sendSms($mobile,$message);

            return ['success' => true];

        } catch (Exception $e) {
            $transaction->rollBack();
            self::orderLog('update_payment_status_error' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }

    }
    public static function orderLog($message) {
        Yii::getLogger()->log($message, Logger::LEVEL_INFO);

    }

    /**
     *
     * 产生随机字符串，不长于32位
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 统计支付成功
     * @return int|string
     */
    public static function countPaySuccess()
    {
        $count= self::find()->where(['payment_status'=>Order::PAYMENT_STATUS_SUCCESS,'status'=>Order::STATUS_NORMAL])->count();
        return $count;
    }
}
