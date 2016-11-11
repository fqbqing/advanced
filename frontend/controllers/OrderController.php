<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 2016/11/11 0011
 * Time: 10:14
 */
namespace frontend\controllers;
use common\models\Order;
use yii;
use yii\log\Logger;
class OrderController extends BaseController
{
    /**
     * 新增订单
     * @params
     */
    public function actionAdd()
    {
        
        $orderId=self::getOrderIdChar();
        $status = Order::STATUS_NORMAL;
        $paymentStatus =  Order::PAYMENT_STATUS_NOT_PAY;
        $formInfoId = $this->getParam('formInfoId');
        $amount =  $this->getParam('amount');
        $exhibitionId =  $this->getParam('exhibitionId');
        $model = new Order();
        //TODO 找不到订单对应的表单信息；
        if(!isset($formInfoId)){
            $message = '找不到订单对应的表单信息';
            Order::orderLog('order_add_error:' . $message);
            return $this->renderJson(['success'=>false,'message'=>$message]);
        }

        $extra['user_name'] = $this->getParam('userName');
        $extra['user_phone'] = $this->getParam('userPhone');
        $extra['subject'] = $this->getParam('subject');
        $extra['deposit'] = $amount;

        $model->setAttributes([
            'form_info_id'=> (int)$formInfoId,
            'exhibition_id'=> (int)$exhibitionId,
            'amount'=>(int)$amount,
            'status'=>$status,
            'extra'=>json_encode($extra),
            'valid_status'=>$status,
            'payment_status'=>$paymentStatus,
            'order_id'=>$orderId
        ]);

        $resultSave = $model->save();
        if ($resultSave != 1) {
            $message = '生成订单失败.';
            Order::orderLog('order_add_error:' . array_values($model->getFirstErrors())[0]);
            return $this->renderJson(['success'=>false,'message'=>$message]);
        }
        Order::orderLog('order_add' . json_encode($model->attributes));
        return $this->renderJson(['success'=>true,'message'=>'生成订单成功.','data'=>['orderId'=>$model->order_id]]);
    }
    //生成显示订单号
    private static function getOrderIdChar()
    {
        $time = explode(" ", microtime());
        $time2 = explode(".", $time[0]);
        $time = $time[1] . substr($time2[1], 0, 3);
        $randNum = rand(100, 999);

        return $time . $randNum;
    }
    public function actionPayment()
    {
        $orderId = $this->getParam('orderId');
        $model = Order::find()->andWhere(['order_id' => $orderId])->asArray()->one();
        if (!isset($model) || empty($model)) {
            $message = '找不到该订单';
            return $this->renderJson(['success'=>false,'message'=>$message]);
        }
        if (intval($model['status']) !== Order::STATUS_NORMAL) {
            return $this->renderJson(['success'=>false,'message'=>'订单状态错误，不能进行支付']);
        }
        $extra = json_decode($model['extra'], true);

        $deposit = $extra['deposit'];
        $data = ['orderId' => $model['order_id'], 'deposit' => $deposit];

        return $this->renderPartial('payment.html', ['payment' => $data]);
    }
}