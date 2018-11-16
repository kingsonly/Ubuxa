<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;

/**
 * This is the model class for table "{{%component_template_attribute}}".
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
 * @property ComponentAttribute[] $componentAttributes //Lol Yii na winch - this is because a foreign key comes from
 * component_attribute to this
 *
 * @property ComponentTemplate $componentTemplate
 * @property ComponentAttributeType $attributeType
 */
class ComponentTemplateAttribute extends BoffinsArRootModel 
{
	public $baseNameSpace = "frontend\models";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%component_template_attribute}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['component_template_id', 'attribute_type_id', 'name', 'cid'], 'required'],
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
            'id' => Yii::t('component', 'ID'),
            'component_template_id' => Yii::t('component', 'Template'),
            'name' => Yii::t('component', 'Name'),
            'format' => Yii::t('component', 'Format'),
            'attribute_type_id' => Yii::t('component', 'Data Type'),
            'show_in_grid' => Yii::t('component', 'Show In Grid'),
            'sort_order' => Yii::t('component', 'Sort Order'),
            'cid' => Yii::t('component', 'Customer Number'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery or subclass
     */
    public function getComponentAttributes()
    {
        return $this->hasMany(ComponentAttribute::className(), ['component_template_attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery or subclass
     */
    public function getComponentTemplate()
    {
        return $this->hasOne(ComponentTemplate::className(), ['id' => 'component_template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery or subclass
     */
    public function getComponentAttributeType()
    {
        return $this->hasOne(ComponentAttributeType::className(), ['id' => 'attribute_type_id']);
    }
		
	/**
	 *  @brief A protected function to retrieve the value class for the value type used by = this attribute template. 
	 *  
	 *  @return string. The value class of the value type used by this attribute template
	 *  
	 *  @details This uses the attribute_type_id of the attribute template to get the value type 
	 *  then converts the value type to a value class name. 
	 */
	public function getValueClassName()
	{
		$valueType = $this->componentAttributeType->type;
		return $this->baseNameSpace . "\\" . self::convertToValueClass($valueType);
	}
	
	/***
	 *  @brief converts a snake_case string to CamelCase and adds the string prefic 'Value'
	 *  
	 *  @param [in] $attribute_type This should be a string that describes a attribute/value type
	 *  @return string. The known class name of the value type given the value type meta
	 *  
	 *  @details valueType, valueMeta and attributeType describe the same thing and should always provide a consistens answer
	 *  Class Names are defined thus 'Value' . valueType/valueMeta/attributeType
	 */
	public static function convertToValueClass($valueType)
	{
		return "Value" . str_replace('_', '', ucwords($valueType, '_'));
	}
	
	public static function find() 
	{
		return new \yii\db\ActiveQuery(get_called_class());
	}

}
