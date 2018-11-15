<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%value_variant_string}}".
 *
 * @property int $id table is for json, html etc dumps or serialised objects not known.
 * @property string $value
 * @property string $type a preferred data type to convert the value to if it is not serialised - this is not indexed
 */
class ValueVariantString extends \boffins_vendor\classes\models\ValueARModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_variant_string}}';
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
            'id' => Yii::t('component', 'ID'),
            'value' => Yii::t('component', 'Value'),
            'type' => Yii::t('component', 'Type'),
        ];
    }
}
