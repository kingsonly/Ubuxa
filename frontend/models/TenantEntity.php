<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%entity}}".
 *
 * @property int $id
 * @property string $entity_type
 *
 * @property Corporation[] $corporations
 * @property Customer[] $customers
 * @property Person[] $people
 */
class TenantEntity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const TENANTENTITY_PERSON = 'person';
    const TENANTENTITY_CORPORATION = 'corporation';

    public static function tableName()
    {
        return '{{%entity}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_tenant');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entity_type'], 'required'],
            [['entity_type'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_type' => 'Account Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorporations()
    {
        return $this->hasMany(TenantCorporation::className(), ['entity_id' => 'id']);
    }
	public function getCorporation()
    {
        return $this->hasOne(TenantCorporation::className(), ['entity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['entity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(TenantPerson::className(), ['entity_id' => 'id']);
    }

    public function getFirstname(){
        $attributes = [];
        $data = $this->people;
        foreach($data as $attr) {
            $attributes[] = $attr->first_name;
        }
        return implode("", $attributes);
    }

    public function getSurname(){
        $attributes = [];
        $data = $this->people;
        foreach($data as $attr) {
            $attributes[] = $attr->surname;
        }
        return implode("", $attributes);
    }

    public function getOptions()
    {
       return array(
          'person',
          'corporation',
       );
    }
}
