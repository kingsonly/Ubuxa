<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_value_integer".
 *
 * @property int $id
 * @property int $value the actual value of the cell
 */
class ValueInteger extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_value_integer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
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
