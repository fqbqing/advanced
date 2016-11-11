<?php
namespace common\components;

use Yii;
use yii\base\Event;
use yii\base\Component;
use yii\web\HttpException;

use common\components\SmInterface;

class SmAoyi extends Component implements SmInterface
{
    public $username;

    public $password;
    /**
     * @param $mobiles
     * @param $content
     * @return mixed
     */
    public function send($mobiles, $content)
    {
        //检查短信开发是否关闭
        if (!empty(yii::$app->params['send_sms']) && yii::$app->params['send_sms'] == 'close') {
            $returnValue['SendSmsTradeResult'] = 1;
            return (object)$returnValue;
        }
        $url = 'http://101.200.228.238/smsport/default.asmx/SendSms';
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "phonelist=$mobiles&msg=$content&username={$this->username}&password={$this->password}&longnum=");
            $result = curl_exec($ch);
            curl_close($ch);
            $data = simplexml_load_string($result);
            if (!empty($data)) {
                $data = (array)$data;
                if (substr($data[0], 0, 1) > 0) {
                    $returnValue['SendSmsTradeResult'] = 1;
                } else {
                    $returnValue['SendSmsTradeResult'] = 0;
                }
            } else {
                $returnValue['SendSmsTradeResult'] = 0;
            }
        } catch (\Exception $e) {
            $returnValue['SendSmsTradeResult'] = 0;
        }
        return $returnValue;
    }

    public function send_bak($mobiles, $content)
    {
        $client = new \SoapClient("http://101.200.228.238/SmsPortTrade/default.asmx?WSDL");
        $client->soap_defencoding = 'utf-8';
        $client->decode_utf8 = false;
        $client->xml_encoding = 'utf-8';
        $aryPara = array(
            'username' => $this->username,
            'password' => $this->password,
            'phonelist' => is_string($mobiles) ? $mobiles : implode(',', $mobiles),
            'msg' => $content,
            'longnum' => ''
        );
        $result = $client->SendSmsTrade($aryPara);
        return $result;
    }

    /**
     * try {} catch(\Exception $e) { var_dump($e->getMessage()); }
     */
    public function getBalance()
    {
        $username = $this->username;
        $password = $this->password;
        $gateway = "http://101.200.228.238/smsport/default.asmx/GetOrderInfo?username=$username&password=$password";
        $result = file_get_contents($gateway);
        $respObject = @simplexml_load_string($result);
        if (false === $respObject) {
            throw new \Exception('100', $result);
        } else {
            $respArray = json_decode(json_encode($respObject), true);
            if (substr($respArray[0], 0, 1) == '-') {
                throw new \Exception($result, 1);
            }
            $arr = explode('|', $respArray[0]);
            return $arr[1];
        }
    }

}
