<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%component_attribute_trait}}".
 *
 * @property int $attribute_id foreign key to trait table
 * @property int $trait_id foreign key to component_template_attribute table
 */
class ComponentAttributeTrait extends \boffins_vendor\classes\BoffinsArRootModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%component_attribute_trait}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['attribute_id', 'trait_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attribute_id' => Yii::t('component', 'Attribute ID'),
            'trait_id' => Yii::t('component', 'Trait ID'),
        ];
    }
}
