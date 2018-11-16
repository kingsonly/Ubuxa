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
 */
class ComponentAttribute extends BoffinsArRootModel implements Sortable
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::className(), ['id' => 'component_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTemplateAttribute()
    {
        return $this->hasOne(ComponentTemplateAttribute::className(), ['id' => 'component_template_attribute_id']);
    }
	
	/**
	 *  @brief retrieve the relation between the attribute and it's actual value (a member of ValueARModel)
	 *  
	 *  @return \yii\db\ActiveQuery or subclass
	 *  
	 *  @details retrieves the valueClassName from the attribute Template (componentTemplateAttribute relation)
	 *  and then uses value_id to retrieve the actual relation
	 */
	protected function getValueObject()
	{
		$valueClassName = $this->componentTemplateAttribute->valueClassName;
		return $this->hasOne($valueClassName::className(), ['id' => 'value_id']);
	}
	
	public function getValue()
	{
		if (empty($this->valueObject)) {
			Yii::warning("Trying to get a value for an attribute but the value record is empty!");
			return '';
		}
		return $this->valueObject->stringValue();
	}
	
	public function getSortField()
	{
		return $this->value->sortfield;
	}
	
	public function getName()
	{
		return $this->componentTemplateAttribute->name;
	}
}
