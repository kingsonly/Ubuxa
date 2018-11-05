<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_value_timestamp".
 *
 * @property int $id
 * @property string $value the actual value of the cell
 */
class ValueTimestamp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_value_timestamp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'safe'],
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
