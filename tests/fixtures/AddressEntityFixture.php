<?php
namespace frontend\tests\fixtures;

use yii\test\ActiveFixture;

class AddressEntityFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\AddressEntity';
	public $depends = [
						'frontend\tests\fixtures\EntityFixture',
						'frontend\tests\fixtures\AddressFixture',
					];
}