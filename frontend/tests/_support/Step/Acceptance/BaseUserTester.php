<?php
namespace frontend\tests\Step\Acceptance;

class BaseUserTester extends \frontend\tests\AcceptanceTester
{

    public function login()
    {
        $I = $this;
		$I->amOnPage('/site/login');
		$I->fillField('#loginform-username', 'admin');
        $I->fillField('#loginform-password', 'secreter');
        $I->click('Login');
		$I->wait(20);
    }

}