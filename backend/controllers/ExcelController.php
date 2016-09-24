<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 2016/9/2 0002
 * Time: 17:53
 */
namespace backend\controllers;

use Yii;
use common\models\Config;
use yii\base\Model;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class ExcelController extends Controller
{
    public function actionConfig($group = 'site')
    {
        //$groups = Yii::$app->config->get('CONFIG_GROUP');

        $dataProvider = new ActiveDataProvider([
            'query' => Config::find()->where(['group' => $group]),
            'pagination' => false
        ]);
        return $this->render('config', [
            //'groups' => $groups,
            'group' => $group,
            'dataProvider' => $dataProvider
        ]);
    }

}