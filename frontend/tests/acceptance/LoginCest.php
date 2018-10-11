<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class LoginCest
{
    public function checkLoginPage(\frontend\tests\Step\Acceptance\BaseUserTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
		$I->expectTo("See some key elements on the page");
        $I->canSee('TycolMain');
        //$I->canSee(['name' => 'login-button']);
        $I->canSee('Login');
		$I->login();
		
		
        /*$I->click('About');
        $I->wait(2); // wait for page to be opened

        $I->see('This is the About page.');*/
    }
}
