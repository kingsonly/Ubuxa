<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_address_entity".
 *
 * @property integer $address_id
 * @property integer $entity_id
 */
class AddressEntity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address_entity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_id', 'entity_id'], 'required'],
            [['address_id', 'entity_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address_id' => 'Address ID',
            'entity_id' => 'Entity ID',
        ];
    }
}
