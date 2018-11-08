<?php

namespace app\models;

use Yii;
use app\boffins_vendor\behaviors\DeleteUpdateBehavior;
/**
 * This is the model class for table "{{%tm_client}}".
 *
 * @property integer $id
 * @property integer $corporation_id
 *
 * @property Corporation $corporation
 * @property Project[] $Projects
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['corporation_id'], 'required'],
            [['corporation_id'], 'integer'],
            [['corporation_id'], 'unique'],
            [['corporation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Corporation::className(), 'targetAttribute' => ['corporation_id' => 'id']],
        ];
    }
	
	public function behaviors(){
		 return [
		"deleteUpdateBehavior2" => DeleteUpdateBehavior::className(),
			 ];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'corporation_id' => 'Corporation ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporation()
    {
        return $this->hasOne(Corporation::className(), ['id' => 'corporation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['client_id' => 'id']);
    }
    
	/**
     * CHANGES BY BOFFINS
     */
	 

    //Added by kingsley of buffin systems
    public static function get_clientid($id)
	{
         $compid=Client::findOne(['id' => $id,]);
        return $compid->corporation_id;
    }
        
     public static function get_client_name($id)
	 {
         return Corporation::getclientname($id);
    }
    
    
    public static function get_all_clientid()
	{
        return Client::find()->asArray()->indexBy('id')->all();
         
    }
	
	
	//Added by Anthony
		
	public function getName() {
		return $this->corporation->name;
	}
	
	public function getShortName() {
		return $this->corporation->shortName;
	}
	
	public function getNameString() {
		return $this->corporation->NameString;
	}

}
