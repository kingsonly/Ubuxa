<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{KnownClass};

/**
 * This is the model class for table "{{%state}}".
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 *
 * @property Country $country
 */
class State extends \yii\db\ActiveRecord implements KnownClass
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%state}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['country_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'country_id' => 'Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
	
	/**
	 *  @brief needed to implement KnownClass
	 *  
	 *  @return string that describes an instance
	 */
	public function getNameString() : string
	{
		return $this->name;
	}
}
