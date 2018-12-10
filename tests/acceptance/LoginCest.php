<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class LoginCest
{
    public function checkLoginPage(\frontend\tests\_support\Step\Acceptance\BaseUserTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
		//$I->expectTo("See some key elements on the page");
        //$I->canSee('TycolMain');
        //$I->canSee(['name' => 'login-button']);
        //$I->canSee('Login');
		//$I->seeCookie('ds');
		//$I->login('admin', 'secreter');
		
		
        /*$I->click('About');
        $I->wait(2); // wait for page to be opened

        $I->see('This is the About page.');*/
    }
}
