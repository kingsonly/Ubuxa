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
        return $this->hasMany(Corporation::className(), ['entity_id' => 'id']);
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
        return $this->hasMany(Person::className(), ['entity_id' => 'id']);
    }

    public function getOptions()
    {
       return array(
          'person',
          'corporation',
       );
    }
}
