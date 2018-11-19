<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%onboarding}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_status
 * @property int $remark_status
 *
 * @property User $user
 */
class Onboarding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const ONBOARDING_COMPLETED = 1;

    const ONBOARDING_NOT_STARTED = 0;
    
    public static function tableName()
    {
        return '{{%onboarding}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'task_status', 'remark_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_status' => 'Task Status',
            'remark_status' => 'Remark Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

}
