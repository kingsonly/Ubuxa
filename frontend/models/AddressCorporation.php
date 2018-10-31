<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%tm_address_corporation}}".
 *
 * @property integer $address_id
 * @property integer $corporation_id
 *
 * @property TmAddress $address
 * @property TmCorporation $corporation
 */
class AddressCorporation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address_corporation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_id', 'corporation_id'], 'required'],
            [['address_id', 'corporation_id'], 'integer'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
            [['corporation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corporation::className(), 'targetAttribute' => ['corporation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address_id' => 'Address ID',
            'corporation_id' => 'Corporation ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporation()
    {
        return $this->hasOne(Corporation::className(), ['id' => 'corporation_id']);
    }
}
