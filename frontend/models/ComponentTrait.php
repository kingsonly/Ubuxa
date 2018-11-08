<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_component_trait".
 *
 * @property int $id
 * @property string $name just a name for the trait
 * @property string $class_name a classname to the trait
 */
class ComponentTrait extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component_trait';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 55],
            [['class_name'], 'string', 'max' => 255],
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
            'class_name' => 'Class Name',
        ];
    }
}
