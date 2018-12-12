<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
//use frontend\tests\functional\BaseUserTester;

class FolderCest 
{
    public function _before(FunctionalTester $I)
    {   
        $I->amOnRoute('site/login');
        $admin = \frontend\models\UserDb::findByUsername('guest');
        $I->amLoggedInAs($admin);
        $I->amOnPage('folder/index');
    }

    // tests
    public function createFolder(FunctionalTester $I) {
        $I->seeInCurrentUrl('folder%2Findex');
        $I->click('#plus');
        $I->fillField('#create-new-create-widget-id-title','Public folder');
        $I->click('Create');
        
    }

    public function createPrivateFolder(FunctionalTester $I) {
        $I->seeInCurrentUrl('folder%2Findex');
        $I->click('#plus');
        $I->click('#sss');
        $I->selectOption('#sss', 'Private');
        $I->seeInField("#sss", 'Private');
        $I->fillField('#create-new-create-widget-id-title','Private folder');
        $I->click('Create');
    } 



}


