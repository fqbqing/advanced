<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use common\modules\user\models\User;
use yii\bootstrap\Nav;
use yii\web\View;

/**
 * @var View 	$this
 * @var User 	$user
 * @var string 	$content
 */

$this->title = '修改用户';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body no-padding">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav nav-pills nav-stacked',
                    ],
                    'items' => [
                        ['label' => '<i class="fa fa-user"></i>帐户详情', 'url' => ['/user/admin/update', 'id' => $user->id], 'encode' => false],
                    
                    ],
                ]) ?>
            </div>
        </div>

         <div class="box box-solid">
            <div class="box-body no-padding">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav nav-pills nav-stacked',
                    ],
                    'items' => [
                        [
                            'label' => '<i class="fa fa-hand-paper-o"></i> '.Yii::t('app', '确认'),
                            'url'   => ['/user/admin/confirm', 'id' => $user->id],
                            'visible' => !$user->isConfirmed,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => '确认该用户?',
                            ],
                            'encode' => false
                        ],
                        [
                            'label' => '<i class="fa   fa-ban "></i> '.Yii::t('app', '锁定'),
                            'url'   => ['/user/admin/block', 'id' => $user->id],
                            'visible' => !$user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => '确定锁定该用户?',
                            ],
                            'encode' => false
                        ],
                        [
                            'label' => '<i class="fa fa-check"></i> '.Yii::t('app', '取消锁定'),
                            'url'   => ['/user/admin/block', 'id' => $user->id],
                            'visible' => $user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => '您确定要取消锁定该用户?',
                            ],
                            'encode' => false
                        ],
                        [
                            'label' =>'<i class="fa fa-trash-o"></i> '. Yii::t('app', '删除'),
                            'url'   => ['/user/admin/delete', 'id' => $user->id],
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => '您确定要删除该用户?',
                            ],
                            'encode' => false
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-solid">
            <div class="box-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
