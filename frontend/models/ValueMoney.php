<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%value_money}}".
 *
 * @property int $id
 * @property string $value the actual value of the cell
 */
class ValueMoney extends \boffins_vendor\classes\BoffinsArRootModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_money}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'number'],
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
