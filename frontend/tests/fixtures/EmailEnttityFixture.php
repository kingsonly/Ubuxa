<?php
namespace frontend\tests\fixtures;

use yii\test\ActiveFixture;

class EmailEntityFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\EmailEntity';
	public $depends = [
						'frontend\tests\fixtures\EntityFixture',
						'frontend\tests\fixtures\EmailFixture',
					];
}