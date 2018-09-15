<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%email}}".
 *
 * @property integer $id
 * @property string $address
 *
 * @property TmEmailEntity[] $tmEmailEntities
 */
class Email extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['address'], 'required'],
            [['address'], 'email'],
            [['cid'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>  Yii::t('Email', 'ID'),
            'address' =>  Yii::t('Email', 'Email Address'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTmEmailEntities()
    {
        return $this->hasMany(EmailEntity::className(), ['email_id' => 'id']);
    }
}
