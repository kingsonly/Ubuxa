<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_folder_component".
 *
 * @property int $folder_id
 * @property int $component_id
 *
 * @property Folder $folder
 * @property Component $component
 */
class FolderComponent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_folder_component';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['folder_id', 'component_id'], 'required'],
            [['folder_id', 'component_id'], 'integer'],
            [['folder_id', 'component_id'], 'unique', 'targetAttribute' => ['folder_id', 'component_id']],
            [['folder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Folder::className(), 'targetAttribute' => ['folder_id' => 'id']],
            [['component_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::className(), 'targetAttribute' => ['component_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'folder_id' => 'Folder ID',
            'component_id' => 'Component ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolder()
    {
        return $this->hasOne(Folder::className(), ['id' => 'folder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponent()
    {
        return $this->hasOne(Component::className(), ['id' => 'component_id']);
    }
}
