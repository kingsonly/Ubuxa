<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%activity_object_class}}".
 *
 * @property int $id
 * @property string $class_name The full class name - including namespace
 * @property string $controller_name The full class name - including namespace of the controller
 */
class ActivityObjectClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_object_class}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_name', 'controller_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'The full class name - including namespace',
            'controller_name' => 'The full class name - including namespace of the controller',
        ];
    }
}
