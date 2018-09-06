<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%telephone_corporation}}".
 *
 * @property integer $telephone_id
 * @property integer $corporation_id
 */
class TelephoneCorporation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%telephone_corporation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['telephone_id', 'corporation_id'], 'required'],
            [['telephone_id', 'corporation_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'telephone_id' =>  Yii::t('TelephoneCorporation', 'Telephone ID'),
            'corporation_id' =>  Yii::t('TelephoneCorporation', 'Corporation ID'),
        ];
    }
}
