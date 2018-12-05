<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%onboarding}}".
 *
 * @property int $id
 * @property int $user_id foreign key to user table
 * @property int $group_id the onboarding group this row is for
 * @property int $status a count of how many times the user has viewed this group?
 *
 * @property OnboardingGroup $group
 * @property User $user
 */
class Onboarding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    CONST ONBOARDING_COUNT = 2; //maximum number of unboarding view
    CONST TASK_ONBOARDING = 1;
    CONST REMARK_ONBOARDING = 2;
    CONST FOLDER_ONBOARDING = 3;
    CONST SUBFOLDER_ONBOARDING = 4;
    CONST MAIN_ONBOARDING = 5;

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
            [['user_id', 'group_id', 'status'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => OnboardingGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserDb::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'group_id' => 'Group ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(OnboardingGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }
}
