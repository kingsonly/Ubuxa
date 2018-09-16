<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%entity}}".
 *
 * @property integer $id
 * @property string $entity_type
 *
 * @property TmEmailEntity[] $tmEmailEntities
 */
class Entity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_type'], 'required'],
            [['entity_type'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>  Yii::t('Entity', 'ID'),
            'entity_type' =>  Yii::t('Entity', 'Entity Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTmEmailEntities()
    {
        return $this->hasMany(EmailEntity::className(), ['entity_id' => 'id']);
    }
	
	//Added by Boffins Systems
	
	const ENTITY_PERSON = 'person';
	const ENTITY_CORPORATION = 'corporation';
}
