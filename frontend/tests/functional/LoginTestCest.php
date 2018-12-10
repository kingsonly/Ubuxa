<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class LoginTestCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnPage('site/login');
        $I->fillField('#loginform-username','admin');
        $I->fillField('#loginform-password','admin');
        $I->click('Login');
        $I->see('Logout');
    }
}
