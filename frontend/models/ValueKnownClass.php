<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%value_known_class}}".
 *
 * @property int $id
 * @property string $value full class name including namespace of the class
 * @property string $query query to be applied against the class to get the instance needed
 */
class ValueKnownClass extends \boffins_vendor\classes\BoffinsArRootModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_known_class}}';
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
            'id' => Yii::t('component', 'ID'),
            'value' => Yii::t('component', 'Value'),
            'query' => Yii::t('component', 'Query'),
        ];
    }
}
