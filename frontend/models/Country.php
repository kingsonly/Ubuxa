<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{KnownClass};

/**
 * This is the model class for table "{{%country}}".
 *
 * @property int $id
 * @property string $sortname
 * @property string $name
 * @property int $phonecode
 *
 * @property State[] $states
 */
class Country extends \yii\db\ActiveRecord implements KnownClass
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sortname', 'name', 'phonecode'], 'safe'],
            [['phonecode'], 'integer'],
            [['sortname'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sortname' => 'Sortname',
            'name' => 'Name',
            'phonecode' => 'Phonecode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(State::className(), ['country_id' => 'id']);
    }
	
	/**
	 *  @brief needed to implement KnownClass
	 *  
	 *  @return string that describes an instance
	 */
	public function getNameString() : string
	{
		return "(+{$this->phonecode}) {$this->name} - {$this->sortname}";
	}
}
