<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class ChromeHomeCest
{
    public function checkHome(AcceptanceTester $I)
    {

        $I->wantTo('Test login page');
		$I->amOnPage(Url::toRoute('/folder/index'));
		$I->fillField('#UserLogin_username', 'test');
		$I->fillField('#UserLogin_password', 'test');

		$I->click("#login-button");

    }
}
