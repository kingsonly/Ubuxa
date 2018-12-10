<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
//use frontend\tests\functional\BaseUserTester;

class TaskCest 
{
    public function _before(FunctionalTester $I)
    {
        
    }

    public function _after(FunctionalTester $I)
    {
    }

    private function executeLogin(FunctionalTester $I){
        $I->amOnPage('site/login');
        $I->seeInCurrentUrl('site/login');
        $I->fillField('#loginform-username', 'guest');
        $I->fillField('#loginform-password', 'guest##99');
        $I->click('Login');
        $I->wait(500);
        return $I;
    }

    // tests
    public function login(FunctionalTester $I) {
        $I = $this->executeLogin($I);

        $I->seeInCurrentUrl('/folder');
    }

}


