<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_component_manager".
 *
 * @property int $component_id
 * @property int $user_id
 * @property string $role
 *
 * @property Component $component
 * @property User $user
 */
class ComponentManager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component_manager';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['component_id', 'user_id', 'role'], 'required'],
            [['component_id', 'user_id'], 'integer'],
            [['role'], 'string'],
            [['component_id', 'user_id'], 'unique', 'targetAttribute' => ['component_id', 'user_id']],
            [['component_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::className(), 'targetAttribute' => ['component_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserDb::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'component_id' => 'Component ID',
            'user_id' => 'User ID',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::className(), ['id' => 'component_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }
}
