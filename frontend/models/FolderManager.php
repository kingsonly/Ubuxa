<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_folder_manager".
 *
 * @property int $folder_id
 * @property int $user_id
 * @property string $role
 *
 * @property Folder $folder
 * @property User $user
 */
class FolderManager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public $privateFoldr;
    public static function tableName()
    {
        return 'tm_folder_manager';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['folder_id', 'user_id', 'role'], 'required'],
            [['folder_id', 'user_id'], 'integer'],
            [['role'], 'string'],
            [['folder_id', 'user_id'], 'unique', 'targetAttribute' => ['folder_id', 'user_id']],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'folder_id' => 'Folder ID',
            'user_id' => 'User ID',
            'role' => 'Role',
			
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
    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }
}
