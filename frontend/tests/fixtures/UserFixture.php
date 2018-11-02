<?php
namespace frontend\tests\fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\UserDB';
	public $depends = [
					'frontend\tests\fixtures\PersonFixture',
					'frontend\tests\fixtures\RoleFixture',
					];
}