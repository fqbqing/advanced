<?php


namespace backend\modules\user\traits;

use backend\modules\user\Module;

trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return \Yii::$app->getModule('user');
    }
}
