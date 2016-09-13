<?php

namespace common\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property integer $id
 * @property integer $money
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $signature
 * @property string $avatar
 * @property integer $gender
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province', 'city', 'area'], 'integer'],
            [['gender'], 'integer'],
            [['signature'], 'string', 'max' => 100],
            [['qq'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^1[0-9]{10}$/'],
            [['avatar'], 'string', 'max' => 255],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' =>'Updated At',
            'signature' => 'Signature',
            'avatar' => 'Avatar',
            'gender' => 'Gender',
            'qq' => 'QQ',
            'phone' => '手机',
            'province' => '省',
            'city' => '市',
            'area' => '区',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function getGenderList()
    {
        return ['先生', '女士'];
    }
}
