<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%plan}}".
 *
 * @property int $id
 * @property string $title
 * @property resource $description
 * @property string $per_user_price
 * @property int $max_users a maximum number of users allowed on plan 0 means no maximum
 */
class Plan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    Const BETA = 1;

    public static function tableName()
    {
        return '{{%plan}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_tenant');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'per_user_price', 'max_users'], 'required'],
            [['description'], 'string'],
            [['per_user_price'], 'number'],
            [['max_users'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'per_user_price' => 'Per User Price',
            'max_users' => 'Max Users',
        ];
    }
}
