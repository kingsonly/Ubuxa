<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_value_short_string".
 *
 * @property int $id
 * @property string $value the actual value of the cell
 */
class ValueShortString extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_value_short_string';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string', 'max' => 255],
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
