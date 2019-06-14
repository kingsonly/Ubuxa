<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%activity_action}}".
 *
 * @property int $id
 * @property string $controller_name The full class name - including namespace of the controller
 * @property string $action The action id - a member of this controller
 */
class ActivityAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_action}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['controller_name', 'action'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller_name' => 'The full class name - including namespace of the controller',
            'action' => 'The action id - a member of this controller',
        ];
    }
}
