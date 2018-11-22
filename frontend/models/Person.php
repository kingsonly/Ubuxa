<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface};

/**
 * This is the model class for table "{{%person}}".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $surname
 * @property string $dob
 * @property string $create_date
 *
 * @property TmPersonCorporation[] $tmPersonCorporations
 */
class Person extends BoffinsArRootModel implements TenantSpecific
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%person}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
            [['first_name', 'surname','cid'], 'required'],
			[['dob','person_id', 'cid'], 'safe'],
            [['first_name', 'surname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'surname' => 'Surname',
            'dob' => 'Dob',
            'create_date' => 'Create Date',
        ];
    }
	
	public function validateDates()
	{
		if(strtotime($this->end_date) <= strtotime($this->start_date)){
			$this->addError('dob','Please give correct Start and End dates');
			$this->addError('end_date','Please give correct Start and End dates');
		}
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonCorporations()
    {
        return $this->hasMany(PersonCorporation::className(), ['person_id' => 'id']);
    }
    
     public function getall_person()
	 {
        return $this->hasMany(PersonCorporation::className(), ['person_id' => 'id']);
	 }
    
    public function allrecords()
	{
        return Person::find()->asArray()->all();
    }
	
	public function getPersonEntityId($personId)
	{
		$entityId = Person::findOne(['id' => $personId,]);
		return $entityId->entity_id;
	}
	
	public function getPersonstring() 
	{
		return $this->surname .' '. $this->first_name;
	}
	
	public function getEmailEntities()
	{
		return $this->hasMany(EmailEntity::className(), ['entity_id' => 'entity_id']);
	}
	public function getTelephoneEntities()
	{
		return $this->hasOne(TelephoneEntity::className(), ['entity_id' => 'entity_id']);
	}
	
	public function getEmails()
	{
		return $this->hasMany(Email::className(), ['id' => 'email_id'])->via('emailEntities');
	}
	public function getEmail()
	{
		return $this->hasOne(Email::className(), ['id' => 'email_id'])->via('emailEntities');
	}
	public function getUserEmail()
	{
		return $this->email->address;
	}
	
	public function getTelephone()
	{
		return $this->hasOne(Telephone::className(), ['id' => 'telephone_id'])->via('telephoneEntities');
	}
	public function getUserTelephone()
	{
		return $this->telephone->telephone_number;
	}

	public function getUser()
	{
		return $this->hasOne(UserDb::className(), ['person_id' => 'id']);
	}
}
