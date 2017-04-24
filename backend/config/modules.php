<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 16/8/30
 * Time: 下午3:53
 */

return [
    'admin' => ['class' => 'mdm\admin\Module',],
    'user' => ['class'
                => 'common\modules\user\Module'],
    'vote' => [
        'class' => 'backend\modules\vote\Module',
    ],
    'post' => [
        'class' => 'backend\modules\post\Module',
    ],
    'rbac' => [
        'class' => 'backend\modules\rbac\Module',
    ],
];