<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%telephone}}".
 *
 * @property integer $id
 * @property string $telephone_number
 */
class Telephone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%telephone}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid'], 'required'],
            [['telephone_number'], 'safe'],
            [['telephone_number'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>  Yii::t('Telephone', 'ID'),
            'telephone_number' =>  Yii::t('Telephone', 'Telephone Number'),
        ];
    }
	
	public function getTelephoneNumber($telephoneid)
	{
		$telephoneId = Telephone::findOne(['id' => $telephoneid,]);
		return $telephoneId->telephone_number;
	}
	
	public function getNumberFromUser($userId)
	{
		$user = Userdb::getPersonId($userId); //there is a bug here waiting to happen! AAO 03/11/18
		$person = Person::getPersonEntityId($user);
		$telephoneEntityId = TelephoneEntity::getEntityId($person);
		$telephone = Telephone::getTelephoneNumber($telephoneEntityId);
		return $telephone;
	}
}
