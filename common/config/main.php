<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'config' => [ //动态配置
            'class' => 'common\\components\\Config',
            'localConfigFile' => '@common/config/main-local.php'
        ],
    ],
];
