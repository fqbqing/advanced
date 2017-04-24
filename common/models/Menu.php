<?php

namespace common\models;


use Yii;
use yii\helpers\Html;


class Menu extends \yii\db\ActiveRecord
{
    public $parent_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','name'], 'required'],
            ['name', 'unique', 'targetAttribute' => ['name', 'parent']],
            [['parent'], 'in', 'range' => static::find()->select(['id'])->column(), 'message' => 'Menu "{value}" not found.', ],
            [['data', 'parent'], 'default'],
           /* ['route', function($attribute){
                if (!empty($this->$attribute)) {
                    $this->addError('route', '一级菜单不能有地址');
                    return false;
                }
                return true;
            }, 'when' => function($model){
                return is_null($model->parent);
            }],*/
            ['icon', 'string'],
            [['order'], 'integer'],
            [['route'], 'in',
                'range' => static::getSavedRoutes(),
                'message' => 'Route "{value}" not found.', ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent' => 'Parent',
            'route' => 'Route',
            'icon' => 'Icon',
            'order' => 'Order',
            'data' =>'Data',
        ];
    }
    
    /**
     * Get saved routes.
     *
     * @return array
     */
    public static function getSavedRoutes()
    {
        $result = [];
        foreach (Yii::$app->getAuthManager()->getPermissions() as $name => $value) {
            if ($name[0] === '/' && substr($name, -1) != '*') {
                $result[] = $name;
            }
        }

        return $result;
    }


}
