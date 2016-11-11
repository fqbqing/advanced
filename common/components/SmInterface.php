<?php
namespace common\components;

use Yii;

interface SmInterface
{
    public function send($mobiles, $content);

    public function getBalance();
}
