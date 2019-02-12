<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%task_group_check}}".
 *
 * @property int $id
 * @property int $status
 * @property int $person_id
 */
class TaskGroupCheck extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_group_check}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'person_id'], 'integer'],
            [['person_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'person_id' => 'Person ID',
        ];
    }
}
