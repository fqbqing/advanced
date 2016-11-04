<?php
namespace common\components\helpers;

use yii;

/**
 * 添加在components目录下的助手函数
 * Class TestHelp
 */
class DateHelper
{
    /**
     * 语义化的时间函数 获取每个月从25号到下个月25号的时间戳区间
     * 计算下一月日期/截至今天为止.超过今天从上一月算起
     * @return array
     */
    public static function getMonthPeriod($dayStart='')
    {
        $now = time();
        //没传年月日中的日，刚取当前日
        $nowDate = date('Y-m-d',$now);
        $dateElements  = explode('-',$nowDate);
        if(empty($dayStart)) $dayStart=$dateElements[2];

        $dt = strtotime(date('Y-m-'.$dayStart.' 00:00:00',$now));
        if($now <$dt){
            $timeStart = strtotime('-1 month',$dt);
            $timeEnd = $dt -1;
        }else{
            $timeStart = $dt;
            $timeEnd =strtotime('+1 month',$dt);
        }
        $timeStart = date('Y-m-d H:i:s',$timeStart);
        $timeEnd = date('Y-m-d H:i:s',$timeEnd);
        return ['timeStart'=>$timeStart,'timeEnd'=>$timeEnd];
    }

    /***/
    public function action12()
    {
        $thisMonArr = $lastMonArr = $longAgoArr = array();
        foreach($billList as $k => $bill) {
            //date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai'   亚洲/上海
            $firstDayOfLastMonth = strtotime('first day of last month');
            $firstDayOfLastMonth = $firstDayOfLastMonth - $firstDayOfLastMonth%86400 - 28800;
            $firstDayOfThisMonth = strtotime('first day of this month');
            $firstDayOfThisMonth = $firstDayOfThisMonth - $firstDayOfThisMonth%86400 - 28800;

            if($bill['create_time'] > $firstDayOfThisMonth) {
                //本月
                $thisMonArr[] = $billDetail;
                if($bill['amount'] < 0 && in_array($bill['bill_type'], C('BILL_CONSUME'))) {
                    $thisMonCount += $bill['amount'];
                }
            } else if($bill['create_time'] > $firstDayOfLastMonth) {
                //上月
                $lastMonArr[] = $billDetail;
                if($bill['amount'] < 0 && in_array($bill['bill_type'], C('BILL_CONSUME'))) {
                    $lastMonCount += $bill['amount'];
                }
            } else {
                //更早
                $longAgoArr[] = $billDetail;
                if($bill['amount'] < 0 && in_array($bill['bill_type'], C('BILL_CONSUME'))) {
                    $longAgoCount += $bill['amount'];
                }
            }
        }
        return;
    }

    /**
     * 校验日期格式是否正确
     * @param string $date 日期
     * @param string $formats 需要检验的格式数组
     * @return boolean
     */
    public static function checkDateIsValid($date, $formats = array("Y-m-d", "Y/m/d")) {
        $unixTime = strtotime($date);
        if (!$unixTime) { //strtotime转换不对，日期格式显然不对。
            return false;
        }
        //校验日期的有效性，只要满足其中一个格式就OK
        foreach ($formats as $format) {
            if (date($format, $unixTime) == $date) {
                return true;
            }
        }
        return false;
    }

}