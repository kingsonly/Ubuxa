<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%value_short_string}}".
 *
 * @property int $id
 * @property string $value the actual value of the cell
 */
class ValueShortString extends \boffins_vendor\classes\BoffinsArRootModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_short_string}}';
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
            'id' => Yii::t('component', 'ID'),
            'value' => Yii::t('component', 'Value'),
        ];
    }
}
