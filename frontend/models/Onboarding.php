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
    CONST MAX_ONBOARDING = 2; //maximum number of unboarding 
    CONST TASK_ONBOARDING_GROUP_ID = 1; //task onboarding group id
    CONST REMARK_ONBOARDING_GROUP_ID = 2; //remark onboarding group id
    CONST FOLDER_DETAILS_ONBOARDING_GROUP_ID = 3; //folder details onboarding group id
    CONST SUBFOLDER_ONBOARDING_GROUP_ID = 4; //subfolder onboarding group id
    CONST MAIN_DASHBOARD_ONBOARDING_GROUP_ID = 5; //dashboard onboarding group id

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

    public function updateOnboarding($userId, $group)
    {
        $model = $this->find()->where(['user_id' => $userId, 'group_id' => $group]);
        $exists = $model->exists();
        if($exists){
            $onboardingModel = $model->one();
            if($onboardingModel->status <  $this::MAX_ONBOARDING){
                $status = $onboardingModel->status;
                $onboardingModel->status = $status + 1;
                $onboardingModel->save();
            }else {
                $onboardingModel->status = $this::MAX_ONBOARDING;
                $onboardingModel->save();
            }
        }else{
            $this->group_id = $group;
            $this->user_id = $userId;
            $this->status = 1;
            $this->save();
        }
    }
}
