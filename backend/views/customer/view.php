<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'exhibition_id',
            'name',
            'sex',
            'mobile',
            'email:email',
            'company_name',
            'position',
            'company_type_id',
            'department',
            'phone',
            'fax',
            'url:url',
            'country',
            'province',
            'city',
            'district',
            'remark:ntext',
            'address',
            'created_at',
            'updated_at',
            'from',
            'status',
            'rejected_reason:ntext',
        ],
    ]) ?>

</div>
