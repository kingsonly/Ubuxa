<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface};

/**
 * This is the model class for table "{{%email}}".
 *
 * @property integer $id
 * @property string $address
 *
 * @property TmEmailEntity[] $tmEmailEntities
 */
class Email extends BoffinsArRootModel implements TenantSpecific
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
			[['address', 'cid'], 'required'],
            [['address'], 'email'],
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
    public function getEmailEntities()
    {
        return $this->hasMany(EmailEntity::className(), ['email_id' => 'id']);
    }

    public function getEmailEntity()
    {
        return $this->hasOne(EmailEntity::className(), ['email_id' => 'id']);
    }

    public function getUser(){
        return $this->emailEntity->entity->person->user;
    }
}
