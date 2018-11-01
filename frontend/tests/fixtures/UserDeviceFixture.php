<?php
namespace frontend\tests\fixtures;

use yii\test\ActiveFixture;

class UserDeviceFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\UserDevice';
	public $depends = [
					'frontend\tests\fixtures\DeviceFixture',
					'frontend\tests\fixtures\UserFixture',
					];
}