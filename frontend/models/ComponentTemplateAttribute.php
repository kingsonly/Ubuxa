<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_component_template_attribute".
 *
 * @property int $id
 * @property int $component_template_id foreign key to component_template table
 * @property string $name just a public name for the customer/user
 * @property string $format a format which this field must conform to at afterfind
 * @property int $attribute_type_id foreign key to component_attribute_type
 * @property int $show_in_grid to track if this field should have a column in grid view
 * @property int $sort_order
 * @property int $cid
 *
 * @property ComponentAttribute[] $componentAttributes
 * @property ComponentTemplate $componentTemplate
 * @property ComponentAttributeType $attributeType
 */
class ComponentTemplateAttribute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component_template_attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['component_template_id', 'attribute_type_id', 'show_in_grid', 'sort_order', 'cid'], 'integer'],
            [['name'], 'string', 'max' => 55],
            [['format'], 'string', 'max' => 255],
            [['component_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponentTemplate::className(), 'targetAttribute' => ['component_template_id' => 'id']],
            [['attribute_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponentAttributeType::className(), 'targetAttribute' => ['attribute_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'component_template_id' => 'Component Template ID',
            'name' => 'Name',
            'format' => 'Format',
            'attribute_type_id' => 'Attribute Type ID',
            'show_in_grid' => 'Show In Grid',
            'sort_order' => 'Sort Order',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentAttributes()
    {
        return $this->hasMany(ComponentAttribute::className(), ['component_template_attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTemplate()
    {
        return $this->hasOne(ComponentTemplate::className(), ['id' => 'component_template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeType()
    {
        return $this->hasOne(ComponentAttributeType::className(), ['id' => 'attribute_type_id']);
    }
}
