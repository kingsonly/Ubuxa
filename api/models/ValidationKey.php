<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "tm_validation_key".
 *
 * @property int $id
 * @property int $key_code
 * @property int $customer_id
 */
class ValidationKey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_validation_key';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key_code', 'customer_id'], 'required'],
            [['key_code', 'customer_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key_code' => 'Key Code',
            'customer_id' => 'Customer ID',
        ];
    }
}
