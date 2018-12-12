<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
//use frontend\tests\functional\BaseUserTester;

class TaskCest 
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $admin = \frontend\models\UserDb::findById('guest');
        $I->amLoggedInAs($admin);
       // $I->amOnPage('folder/index');
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    
    public function tryToTest(FunctionalTester $I)
    {
         $I->amOnPage('folder/index');
         $I->seeInCurrentUrl('folder%2Findex');
         $I->see('test folder');
         $I->click('test folder');
         //$I->see('TASKS');
    }
}