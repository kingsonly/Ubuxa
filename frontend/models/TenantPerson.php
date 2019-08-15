<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%person}}".
 *
 * @property int $id
 * @property int $entity_id
 * @property string $first_name
 * @property string $surname
 * @property string $dob
 * @property string $create_date
 *
 * @property Entity $entity
 */
class TenantPerson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%person}}';
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
            [['entity_id'], 'integer'],
            [['first_name', 'surname'], 'string'],
            [['dob', 'create_date'], 'safe'],
            [['entity_id'], 'exist', 'skipOnError' => true, 'targetClass' => TenantEntity::className(), 'targetAttribute' => ['entity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
            'first_name' => 'First Name',
            'surname' => 'Surname',
            'dob' => 'Date of Birth',
            'create_date' => 'Create Date',
        ];
    }

    public function addPersonTenant($id)
    {
        $this->entity_id = $id;
        $this->create_date = new Expression('NOW()');
        $this->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(TenantEntity::className(), ['id' => 'entity_id']);
    }
}
