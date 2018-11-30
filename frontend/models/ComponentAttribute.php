<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\Sortable;

/**
 * This is the model class for table "{{%component_attribute}}".
 *
 * @property int $id
 * @property int $component_id foreign key to component table
 * @property int $component_template_attribute_id foreign key to component_template_attribute table
 * @property int $value_id foreign key to one of the value tables
 * @property int $cid
 *
 * @property Component $component
 * @property ComponentTemplateAttribute $componentTemplateAttribute
 * @property string Name - the name of this attribute derived from its ComponentTemplateAttribute
 * @property valueInstance - protected property of the object. Properties of the object are accessed via other properties below
 * 
 * @property string value - the public value of the value object of this attribute - read/write
 * @property array  valueMeta - meta data of the value object 
 * @property mixed[probably int|string] the sort field which can be used to sort this attribute
 */
class ComponentAttribute extends \yii\db\ActiveRecord implements Sortable
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%component_attribute}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['component_id', 'component_template_attribute_id', 'value_id', 'cid'], 'integer'],
            [['value'], 'safe'], //essential to be able to have the valueInstance attributed delegated to this AR. 
            [['component_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::className(), 'targetAttribute' => ['component_id' => 'id']],
            [['component_template_attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponentTemplateAttribute::className(), 'targetAttribute' => ['component_template_attribute_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('component', 'ID'),
            'component_id' => Yii::t('component', 'Component ID'),
            'component_template_attribute_id' => Yii::t('component', 'Component Template Attribute ID'),
            'value_id' => Yii::t('component', 'Value ID'),
            'value' => Yii::t('component', 'Value'),
			'name' => Yii::t('component', 'Attribute Name'),
        ];
    }

    /***
     * @return \yii\db\ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::className(), ['id' => 'component_id']);
    }

    /***
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTemplateAttribute()
    {
        return $this->hasOne(ComponentTemplateAttribute::className(), ['id' => 'component_template_attribute_id'])->orderBy([
			'sort_order' => SORT_ASC
		]);
    }
	
	public function getComponentTemplateAttributeShowInGrid()
    {
        return $this->hasOne(ComponentTemplateAttribute::className(), ['id' => 'component_template_attribute_id'])->andWhere(['show_in_grid'=>0])->orderBy([
			'sort_order' => SORT_ASC
		]);
    }
	
	/**
	 *  @brief retrieve the relation between the attribute and it's actual value (a member of ValueARModel)
	 *  
	 *  @return \yii\db\ActiveQuery or subclass
	 *  
	 *  @details retrieves the valueClassName from the attribute Template (componentTemplateAttribute relation)
	 *  and then uses value_id to retrieve the actual relation
	 */
	protected function getValueInstance()
	{
		$valueClassName = $this->componentTemplateAttribute->valueClassName;
		Yii::trace("The return is $valueClassName");
		return $this->hasOne($valueClassName::className(), ['id' => 'value_id']);
	}
	
	/***
	 *  @brief property to retrieve a value of the member valueInstance (an instance of an external ActiveRecord)
	 *  this function is forwarded to the valueInstance
	 *  
	 *  @return the string value (the public value) of the valueInstance
	 */
	public function getValue()
	{
		if (empty($this->valueInstance)) {
			Yii::warning("Trying to get a public value for value object but the object is empty!");
			return '';
		}
		return $this->valueInstance->stringValue();
	}
	
	/***
	 *  @brief property to set a value to the valueInstance (an instance of an external ActiveRecord)
	 *  this is forwarded to the valueInstance
	 *  
	 *  @param [in] $value a new value to be set
	 *  @return VOID
	 */
	public function setValue($value)
	{
		Yii::trace("Setting the value for my value object");
		$this->valueInstance->value = $value;
	}

	/***
	 *  @brief gets the sort field of a given value field 
	 *  
	 *  @return a field in the valueInstance which you can use to sort this attribute among it's peers.
	 *  
	 *  @details This is a rough implementation. This should be built upon to extend functionality 
	 *  to allow extremely dynamic scenarios. 
	 */
	public function getSortField()
	{
		return $this->value->sortField;
	}
	
	/***
	 *  @brief a property to return the name of the ComponentTemplateAttribute which is also the name 
	 *  of this attribute. 
	 *  This property is READ only. To amend this, you should do so directly from its template
	 *  
	 *  @return string 
	 *  
	 *  @details nameString property is an alias for this. 
	 */
	public function getName()
	{
		return $this->componentTemplateAttribute->name;
	}
	
	/***
	 *  @brief property nameString  READ only
	 *  
	 *  @return string - a name that can be presented to a user. For attributes, this is the equivalent of a label.
	 */
	public function getNameString()
	{
		return $this->name;
	}
	
	/***
	 *  @brief property label READ only
	 *  
	 *  @return string - a label for the user to indicate what this attribute is.
	 */
	public function getLabel()
	{
		return $this->name;
	}
	
	/**
	 *  {@inheritdoc}
	 *  
	 *  @details Since attribute forwards its value to the value object, saving this model 
	 *  only makes sense in that values are saved. If the value is not saved, the attibute save should also fail. 
	 */
	public function beforeSave($insert)
	{
		Yii::trace("Starting beforeSave of ComponentAttribute.");
		if ( !$insert ) {
			Yii::trace("Trying to save the value " . __METHOD__ );
			$response = $this->valueInstance->save();
			$msg = $response ? Yii::t('component', 'value_saved') : Yii::t('component', 'value_not_saved');
			if ($response) {
				Yii::trace("$msg " . __METHOD__);
				return parent::beforeSave($insert);
			}
			Yii::warning("$msg " . __METHOD__);
			return false;
		}
		return parent::beforeSave($insert);
	}
	
	public function getType()
	{
		return $this->componentTemplateAttribute->componentAttributeType->type;
	}
	
	public function getTypeName()
	{
		return $this->componentTemplateAttribute->componentAttributeType->name;
	}
}
