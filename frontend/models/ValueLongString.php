<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_value_long_string".
 *
 * @property int $id preferred table for long strings as it has an index for searching
 * @property string $value
 */
class ValueLongString extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_value_long_string';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }
}
