<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/14
 * Time: 15:53
 */
namespace frontend\controllers;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class BaseController extends Controller
{
    public function renderJson($params = array())
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $params;
    }
    protected function getAllParams() {
        return array_merge(Yii::$app->request->post(), Yii::$app->request->get());
    }

    protected function getParam($key) {
        $allParams = $this->getAllParams();
        return isset($allParams[$key]) ? $allParams[$key] : null;
    }
    /**
     * 判断页面是否在微信客户端中打开
     *
     * 注意：此判断方法并不准确，用户可以通过伪造UA绕过，
     *      严格判断请使用从微信获取open id的方法
     *
     * @return bool
     */
    protected function isInWeixin() {
        return !!$this->getVersion();
    }

    /**
     * 获取微信版本号
     *
     * @return bool|float
     */
    protected function getVersion() {
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (preg_match('/MicroMessenger\/([\d.]+)/', $ua, $match)) {
            return floatval($match[1]);
        } else {
            return false;
        }
    }
}