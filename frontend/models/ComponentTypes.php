<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_component_types".
 *
 * @property string $component_name
 * @property string $component_simplename
 * @property string $component_classname
 * @property string $component_junction_model
 * @property string $junction_foreign_key
 */
class ComponentTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['component_name', 'component_simplename', 'component_classname', 'component_junction_model', 'junction_foreign_key'], 'required'],
            [['component_name', 'component_simplename', 'component_classname', 'component_junction_model', 'junction_foreign_key'], 'string', 'max' => 255],
            [['component_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'component_name' => 'Component Name',
            'component_simplename' => 'Component Simplename',
            'component_classname' => 'Component Classname',
            'component_junction_model' => 'Component Junction Model',
            'junction_foreign_key' => 'Junction Foreign Key',
        ];
    }
}
