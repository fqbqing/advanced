<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'sms_signature' => '【尚格会展】',
    'dwzUrl' => 'http://dwz.sungoal.org/app.php',
    //TODO 需要修改
    'getTicketUrl'=>'http://xbh.zhanqu.im/ticket/get-ticket?seqnum=',
    // 支付宝相关
    'alipay.partner' => '2088411945226741',
    'alipay.key' => 'cau8o29wko4khkffe42zld61vmpenyqk',
    'alipay.seller' => '2858932098@qq.com',
    'alipay.charset' => 'utf-8',

    //请在相关域名下使用微信相关功能
    'weixin.appId' => 'wxa2c4fdba1394ce64',
    'weixin.app_secret' => '5b866e4fc32f4875a0805a76ba3e651a',

    //微信支付相关 线下环境 配置
    'weixin.mchId' => '1237885302', //此号码为华中商户号
    'weixin.weixinPayKey' => 'lizong8lulu8meizi8yun8kang8fei88',
    'weixin.scan_orderIdPrefix' => 'scan_',
    'weixin.jsapi_orderIdPrefix' => 'jsapi_',

];
