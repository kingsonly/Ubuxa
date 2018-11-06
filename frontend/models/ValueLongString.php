<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%value_long_string}}".
 *
 * @property int $id preferred table for long strings as it has an index for searching
 * @property string $value
 */
class ValueLongString extends \boffins_vendor\classes\BoffinsArRootModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_long_string}}';
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
            'id' => Yii::t('component', 'ID'),
            'value' => Yii::t('component', 'Value'),
        ];
    }
}
