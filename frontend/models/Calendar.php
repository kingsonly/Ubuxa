<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%calendar}}".
 *
 * @property int $id
 * @property int $last_id
 * @property int $type
 * @property int $user_id
 * @property int $deleted
 * @property string $last_updated
 * @property int $cid
 *
 * @property Event $last
 * @property Task $last0
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%calendar}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_id', 'type'], 'required'],
            [['last_id','user_id', 'deleted', 'cid'], 'integer'],
            [['last_updated'], 'safe'],
            [['last_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['last_id' => 'id']],
            [['last_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['last_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_id' => 'Last ID',
            'type' => 'Type',
            'user_id' => 'User ID',
            'deleted' => 'Deleted',
            'last_updated' => 'Last Updated',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLast()
    {
        return $this->hasOne(Event::className(), ['id' => 'last_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLast0()
    {
        return $this->hasOne(Task::className(), ['id' => 'last_id']);
    }
}
