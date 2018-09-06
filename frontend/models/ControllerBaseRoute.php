<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%controller_base_route}}".
 *
 * @property string $name
 * @property string $base_route
 */
class ControllerBaseRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%controller_base_route}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'base_route'], 'required'],
            [['name', 'base_route'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('ControllerBaseRoute', 'Name'),
            'base_route' => Yii::t('ControllerBaseRoute', 'Base Route'),
        ];
    }
}
