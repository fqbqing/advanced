<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    //定义全局runtime目录
    'runtimePath' => '@root/runtime',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //配置时间戳格式化
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'timeFormat' => 'HH:mm:ss',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        'config' => [ //动态配置
            'class' => 'common\\components\\Config',
            'localConfigFile' => '@common/config/main-local.php'
        ],
        'storage' => [
            'class' => 'common\\components\\Storage',
            'basePath' => '@storagePath/upload',
            'baseUrl' => '@storageUrl/upload'
        ],
    ],
];
