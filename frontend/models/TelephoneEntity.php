<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_telephone_entity".
 *
 * @property integer $telephone_id
 * @property integer $entity_id
 */
class TelephoneEntity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%telephone_entity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['telephone_id', 'entity_id'], 'safe'],
            [['telephone_id', 'entity_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'telephone_id' =>  Yii::t('TelephoneEntity', 'Telephone ID'),
            'entity_id' =>  Yii::t('TelephoneEntity', 'Entity ID'),
        ];
    }
	
	public function getEntityId($entityId)
	{
		$telephoneModel = new TelephoneEntity;
		$telephoneId = $telephoneModel->findOne([
				'entity_id' => 21,
			]);
		return $telephoneId->telephone_id;
		
	}
}
