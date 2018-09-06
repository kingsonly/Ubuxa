<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%role}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $access_level
 *
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'access_level'], 'required'],
            [['id', 'access_level'], 'integer'],
            [['name'], 'string', 'max' => 25],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>  Yii::t('AccessPermission', 'ID'),
            'name' =>  Yii::t('AccessPermission', 'Name'),
            'access_level' =>  Yii::t('AccessPermission', 'Access Level'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['basic_role' => 'id']);
    }
}
