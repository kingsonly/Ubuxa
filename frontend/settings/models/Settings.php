<?php

namespace frontend\settings\models;

use Yii;
use frontend\models\UserSetting;
use mongosoft\file\UploadBehavior;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $value
 * @property string $reason
 */
class Settings extends UserSetting
{
	public function rules()
    {
		//parent::rules();
        return [
            ['logo', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update']],
        ];
    }
	/**
	function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'logo',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/docs/{category.id}',
                'url' => '@web/upload/docs/{category.id}',
            ],
        ];
    }*/
}
