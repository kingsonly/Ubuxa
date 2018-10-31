<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%status_type}}".
 *
 * @property int $id
 * @property string $status_group
 * @property string $status_title
 *
 * @property Device[] $devices
 * @property Task[] $tasks
 */
class StatusType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%status_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_group', 'status_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_group' => 'Status Group',
            'status_title' => 'Status Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::className(), ['status_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['status_id' => 'id']);
    }
}
