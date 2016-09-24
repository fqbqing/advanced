<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Customer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'exhibition_id',
            'name',
            'sex',
            // 'mobile',
            // 'email:email',
            // 'company_name',
            // 'position',
            // 'company_type_id',
            // 'department',
            // 'phone',
            // 'fax',
            // 'url:url',
            // 'country',
            // 'province',
            // 'city',
            // 'district',
            // 'remark:ntext',
            // 'address',
            // 'created_at',
            // 'updated_at',
            // 'from',
            // 'status',
            // 'rejected_reason:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
