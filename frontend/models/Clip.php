<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_clip".
 *
 * @property int $id
 * @property int $bar_id where the clip is attached - the clip bar
 * @property int $owner_id who the clip is for remark? task? other???
 * @property int $owner_type_id clip owner type id
 *
 * @property ClipBar $bar
 * @property ClipOwnerType $ownerType
 */
class Clip extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_clip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bar_id', 'owner_id', 'owner_type_id'], 'integer'],
            [['bar_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClipBar::className(), 'targetAttribute' => ['bar_id' => 'id']],
            [['owner_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClipOwnerType::className(), 'targetAttribute' => ['owner_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bar_id' => 'Bar ID',
            'owner_id' => 'Owner ID',
            'owner_type_id' => 'Owner Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBar()
    {
        return $this->hasOne(ClipBar::className(), ['id' => 'bar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnerType()
    {
        return $this->hasOne(ClipOwnerType::className(), ['id' => 'owner_type_id']);
    }
}
