<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%corporation}}".
 *
 * @property int $id
 * @property int $entity_id
 * @property string $name
 * @property string $create_date
 *
 * @property Entity $entity
 */
class TenantCorporation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%corporation}}';
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
            [['name'], 'string'],
            [['create_date'], 'safe'],
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
            'name' => 'Corporation Name',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(TenantEntity::className(), ['id' => 'entity_id']);
    }
}
