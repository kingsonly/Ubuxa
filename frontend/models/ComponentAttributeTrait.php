<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_component_attribute_trait".
 *
 * @property int $attribute_id foreign key to trait table
 * @property int $trait_id foreign key to component_template_attribute table
 */
class ComponentAttributeTrait extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component_attribute_trait';
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
            'attribute_id' => 'Attribute ID',
            'trait_id' => 'Trait ID',
        ];
    }
}
