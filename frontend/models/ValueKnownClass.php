<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_value_known_class".
 *
 * @property int $id
 * @property string $value full class name including namespace of the class
 * @property string $query query to be applied against the class to get the instance needed
 */
class ValueKnownClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_value_known_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'query'], 'string', 'max' => 255],
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
            'query' => 'Query',
        ];
    }
}
