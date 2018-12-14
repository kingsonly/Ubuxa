<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
//use frontend\tests\functional\BaseUserTester;

class TaskCest 
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $admin = \frontend\models\UserDb::findByUsername('guest');
        $I->amLoggedInAs($admin);
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
         $I->fillField('#addTask','test task again');
         $I->click('#taskButton');
         $I->amOnRoute('folder/view', ['id' => 15]);
         $I->seeInCurrentUrl('folder%2Fview');
         $I->see('test task again');
        
    }

    public function testCompleted(FunctionalTester $I)
    {
         $I->amOnPage('folder/index');
         $I->seeInCurrentUrl('folder%2Findex');
         $I->see('test folder');
         $I->click('test folder');
         $I->see('.todo_listt21');
         /*$I->amOnRoute('folder/view', ['id' => 15]);
         $I->seeInCurrentUrl('folder%2Fview');
         $I->see('#todo-list24','checked');*/
        
    }
}