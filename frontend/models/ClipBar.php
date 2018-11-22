<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface};


/**
 * This is the model class for table "tm_clip_bar".
 *
 * @property int $id
 * @property int $owner_id
 * @property int $owner_type_id
 * @property int $capacity maximum number of clips allowed 0 means no limit
 *
 * @property Clip[] $clips
 * @property ClipBarOwnerType $ownerType
 */
class ClipBar extends BoffinsArRootModel implements TenantSpecific
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_clip_bar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_id', 'owner_type_id', 'capacity'], 'integer'],
            [['owner_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClipBarOwnerType::className(), 'targetAttribute' => ['owner_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'owner_type_id' => 'Owner Type ID',
            'capacity' => 'Capacity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClips()
    {
        return $this->hasMany(Clip::className(), ['bar_id' => 'id']);
    }
	
	

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnerType()
    {
        return $this->hasOne(ClipBarOwnerType::className(), ['id' => 'owner_type_id']);
    }
}
