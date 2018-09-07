<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_user_setting".
 *
 * @property int $id
 * @property string $logo This should point to a location
 * @property string $theme
 * @property string $language should use ISO languages
 * @property string $date_format also use ISO format?
 */
class UserSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tm_user_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'logo', 'theme', 'language', 'date_format'], 'required'],
            [['id'], 'integer'],
            [['logo', 'theme', 'language', 'date_format'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logo' => 'Logo',
            'theme' => 'Theme',
            'language' => 'Language',
            'date_format' => 'Date Format',
        ];
    }
}
