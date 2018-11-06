<?php

namespace frontend\models;

use Yii;

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
class ComponentAttribute extends \boffins_vendor\classes\BoffinsArRootModel
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
            'cid' => Yii::t('component', 'Cid'),
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
}
