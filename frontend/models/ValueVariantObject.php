<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%value_variant_object}}".
 *
 * @property int $id
 * @property resource $value
 * @property string $type for images and raw binaries - avoid use unless essential
 */
class ValueVariantObject extends \boffins_vendor\classes\models\ValueARModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%value_variant_object}}';
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
