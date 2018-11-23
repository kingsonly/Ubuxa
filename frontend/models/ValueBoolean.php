<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%value_boolean}}".
 *
 * @property int $id
 * @property int $value To store boolean values.
 */
class ValueBoolean extends \boffins_vendor\classes\models\ValueARModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_boolean}}';
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
            'id' => Yii::t('component', 'ID'),
            'value' => Yii::t('component', 'Value'),
        ];
    }
}
