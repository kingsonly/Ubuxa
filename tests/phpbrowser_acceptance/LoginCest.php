<?php
namespace frontend\tests\basic_acceptance;

use frontend\tests\BasicAcceptanceTester;
use yii\helpers\Url;

class LoginCest
{
    public function checkLoginPage(\frontend\tests\BasicAcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
		$I->expectTo("See some key elements on the page");
        $I->canSee('TycolMain');
        $I->canSee('Login');
		//$I->seeCookie('ds');
		//$I->login('admin', 'secreter');
		
		
        /*$I->click('About');
        $I->wait(2); // wait for page to be opened

        $I->see('This is the About page.');*/
    }
}
