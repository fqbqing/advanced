<?php

namespace common\modules\user;

use Yii;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $enableGeneratingPassword = true;

    /** @var bool Whether to show flash messages. */
    public $enableFlashMessages = true;

    /** @var bool Whether to enable registration. */
    public $enableRegistration = true;

    /** @var bool Whether user has to confirm his account. */
    public $enableConfirmation = true;

    /** @var bool Whether to allow logging in without confirmation. */
    public $enableUnconfirmedLogin = false;

    /** @var bool Whether to enable password recovery. */
    public $enablePasswordRecovery = true;

    /** @var bool Whether user can remove his account */
    public $enableAccountDelete = false;

    /**  @var string rbac默认管理员permission名 */
    public $adminPermission = 'admin';

    public $admins = [];

    public $defaultPassword = 'zhanqu';

    public $urlPrefix = 'user';

    public $urlRules = [
        '<id:\d+>' => 'default/index',
        '<action:(login|logout)>' => 'security/<action>',
        '<action:(signup)>' => 'registration/<action>',
        '<action:(up|article-list|create-article|update-article|notice|favourite)>' => 'default/<action>',
    ];

    public function init()
    {
        parent::init();
    }

    public function bootstrap($app)
    {
        Yii::$app->set('user', [
            'class' => 'yii\web\User',
            'identityClass' => 'common\modules\user\models\User',
            'loginUrl' => ['/site/login'],
            'enableAutoLogin' => true,
            'on afterLogin' => function($event) {
                $event->identity->touch('login_at');
            }
        ]);


    }
}