<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_log".
 *
 * @property integer $id
 * @property string $route
 * @property string $description
 * @property integer $created_at
 * @property integer $user_id
 * @property integer $ip
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['created_at'], 'required'],
            [['created_at', 'user_id', 'ip'], 'integer'],
            [['route'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => '路由',
            'description' => '详情',
            'created_at' => '操作时间',
            'user_id' => '操作人',
            'ip' => '操作人ip'
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\AdminLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AdminLogQuery(get_called_class());
    }
}
