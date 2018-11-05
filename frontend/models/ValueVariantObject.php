<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_value_variant_object".
 *
 * @property int $id
 * @property resource $value
 * @property string $type for images and raw binaries - avoid use unless essential
 */
class ValueVariantObject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_value_variant_object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string'],
            [['type'], 'string', 'max' => 255],
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
            'type' => 'Type',
        ];
    }
}
