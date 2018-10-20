<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_clip_owner_type".
 *
 * @property int $id
 * @property string $owner_type
 *
 * @property Clip[] $clips
 */
class ClipOwnerType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_clip_owner_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_type'], 'string', 'max' => 255],
            [['owner_type'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_type' => 'Owner Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClips()
    {
        return $this->hasMany(Clip::className(), ['owner_type_id' => 'id']);
    }
}
