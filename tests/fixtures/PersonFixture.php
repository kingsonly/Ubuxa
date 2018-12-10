<?php
namespace frontend\tests\fixtures;

use yii\test\ActiveFixture;

class PersonFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\Person';
	public $depends = [
						'frontend\tests\fixtures\AddressEntityFixture',
						'frontend\tests\fixtures\EmailEntityFixture',
						'frontend\tests\fixtures\EntityFixture',
					];

}