<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_component_component".
 *
 * @property int $component_id foreign key to component table
 * @property int $linked_component foreign key to component table
 *
 * @property Component $component
 * @property Component $linkedComponent
 */
class ComponentComponent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component_component';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['component_id', 'linked_component'], 'integer'],
            [['component_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::className(), 'targetAttribute' => ['component_id' => 'id']],
            [['linked_component'], 'exist', 'skipOnError' => true, 'targetClass' => Component::className(), 'targetAttribute' => ['linked_component' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'component_id' => 'Component ID',
            'linked_component' => 'Linked Component',
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
    public function getLinkedComponent()
    {
        return $this->hasOne(Component::className(), ['id' => 'linked_component']);
    }
}
