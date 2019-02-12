<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%onboarding_group}}".
 *
 * @property int $id
 * @property string $group_name The name of the onboarding group (task, remarks etc)
 * @property int $group_status whether or not this onboarding group is active or not
 *
 * @property Onboarding[] $onboardings
 */
class OnboardingGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%onboarding_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_status'], 'integer'],
            [['group_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_name' => 'Group Name',
            'group_status' => 'Group Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOnboardings()
    {
        return $this->hasMany(Onboarding::className(), ['group_id' => 'id']);
    }
}
