<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $exhibition_id
 * @property string $name
 * @property integer $sex
 * @property string $mobile
 * @property string $email
 * @property string $company_name
 * @property string $position
 * @property integer $company_type_id
 * @property string $department
 * @property string $phone
 * @property string $fax
 * @property string $url
 * @property integer $country
 * @property integer $province
 * @property integer $city
 * @property integer $district
 * @property string $remark
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property string $rejected_reason
 */
class Customer extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_REJECTED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'exhibition_id', 'sex', 'company_type_id', 'country', 'province', 'city', 'district', 'status'], 'integer'],
            [['exhibition_id', 'name', 'mobile', 'email', 'company_name', 'position'], 'required'],
            [['remark', 'rejected_reason'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'mobile', 'phone', 'fax'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 64],
            [['company_name', 'position', 'department', 'url', 'address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'type' => '客户类型',
            'exhibition_id' => '展会id',
            'name' => '姓名',
            'sex' => '称谓',
            'mobile' => '手机',
            'email' => '邮箱',
            'company_name' => '单位名称',
            'position' => '职务',
            'company_type_id' => '公司类型',
            'department' => '部门',
            'phone' => '电话',
            'fax' => '传真',
            'url' => '网址',
            'country' => 'Country',
            'province' => '省id',
            'city' => '市id',
            'district' => '区id',
            'remark' => '备注',
            'address' => '地址',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'status' => '0:待审1、通过、9、驳回',
            'rejected_reason' => '拒绝原因',
        ];
    }
}
