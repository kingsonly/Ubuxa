<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_component_attribute_type".
 *
 * @property int $id types may be money/amount, string, object 
 * @property string $name just a public name for the customer/user
 * @property string $type must be a type: integer, varchar, decimal, classname, or blob
 * @property string $default_format a default format if the user does not set one
 *
 * @property ComponentTemplateAttribute[] $componentTemplateAttributes
 */
class ComponentAttributeType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component_attribute_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 55],
            [['type', 'default_format'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'default_format' => 'Default Format',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTemplateAttributes()
    {
        return $this->hasMany(ComponentTemplateAttribute::className(), ['attribute_type_id' => 'id']);
    }
}
