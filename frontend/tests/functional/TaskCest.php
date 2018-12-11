<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
//use frontend\tests\functional\BaseUserTester;

class TaskCest 
{
    public function _before(FunctionalTester $I)
    {
        $admin = \frontend\models\UserDb::findByUsername('guest');
        $I->amLoggedInAs($admin);
    }

    // tests
    public function createFolder(FunctionalTester $I) {
        $I->amOnPage('folder/index');
        $I->seeInCurrentUrl('folder%2Findex');
        $I->click('#plus');
        $I->fillField('#create-new-create-widget-id-title','New folder');
        $I->click('Create');
    } 

}


