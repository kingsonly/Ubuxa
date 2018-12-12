<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
use Yii;
//use frontend\tests\functional\BaseUserTester;

class FolderCest 
{
    public function _before(FunctionalTester $I)
    {   
        $admin = \frontend\models\UserDb::findByUsername('guest');
        $I->amLoggedInAs($admin);
    }

    // tests
    public function createFolder(FunctionalTester $I) 
    {
        $I->amOnPage('folder/index');
        $I->seeInCurrentUrl('folder%2Findex');
        $I->click('#plus');
        $I->fillField('#create-new-create-widget-id-title','Public folder');
        $I->click('Create');
        $I->seeInCurrentUrl('folder%2Fcreate');
        //$I->see('Public Folder');
    }

    public function createPrivateFolder(FunctionalTester $I) 
    {
        $I->amOnPage('folder/index');
        $I->seeInCurrentUrl('folder%2Findex');
        $I->click('#plus');
        $I->click('#sss');
        $I->selectOption('#sss', 'Private');
        $I->seeInField("#sss", 'Private');
        $I->fillField('#create-new-create-widget-id-title','Private folder');
        $I->click('Create');
        
    }

     

}


