<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_email_entity".
 *
 * @property integer $email_id
 * @property integer $entity_id
 */
class EmailEntity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_entity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_id', 'entity_id'], 'required'],
            [['email_id', 'entity_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email_id' => Yii::t('EmailEntity', 'Email Address'),
            'entity_id' => Yii::t('EmailEntity', 'Entity ID'),
        ];
    }
}
