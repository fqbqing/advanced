<?php
Yii::setAlias('root', dirname(dirname(__DIR__)));
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@rest', dirname(dirname(__DIR__)) . '/rest');

Yii::setAlias('storagePath', '@root/storage');
Yii::setAlias('storageUrl', 'http://advanced.dev.com/storage');

//依赖注入容器  构造、Setter 和属性注入
Yii::$container->set('yii\widgets\LinkPager', ['firstPageLabel' => '首页', 'lastPageLabel' => '末页']);

