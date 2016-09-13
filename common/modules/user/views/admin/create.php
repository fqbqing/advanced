<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var yii\web\View 				$this
 * @var dektrium\user\models\User 	$user
 */

$this->title = '创建一个帐户';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        ['label' => '帐户', 'url' => ['/user/admin/create']],
                        ['label' => '信息', 'options' => [
                            'class' => 'disabled',
                            'onclick' => 'return false;',
                        ]],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-info">
                    如果没有提供密码，将自动生成.
                </div>
                <?php $form = ActiveForm::begin([
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false
                ]); ?>

                <?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

                <div class="form-group">
                    <?= Html::submitButton( '创建', ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
