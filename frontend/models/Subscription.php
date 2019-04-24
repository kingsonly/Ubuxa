<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\models\{TenantSpecific};

/**
 * This is the model class for table "{{%subscription}}".
 *
 * @property string $id
 * @property int $user_id
 * @property int $object_id
 * @property int $object_class_id
 * @property string $action_id Should really map to a class of actions such as folderview mapped to view
 * @property int $cid
 *
 * @property User $object
 * @property User $user
 */
class Subscription extends \boffins_vendor\classes\BoffinsArRootModel implements TenantSpecific
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id', 'object_id', 'object_class_id', 'cid'], 'integer'],
            [['id', 'action_id'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['object_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityObjectClass::className(), 'targetAttribute' => ['object_class_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserDb::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'object_id' => Yii::t('app', 'Object ID'),
            'object_class_id' => Yii::t('app', 'Object Class ID'),
            'action_id' => Yii::t('app', 'Should really map to a class of actions such as folderview mapped to view'),
            'cid' => Yii::t('app', 'Cid'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityObjectClass()
    {
        return $this->hasOne(ActivityObjectClass::className(), ['id' => 'object_class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }
}
