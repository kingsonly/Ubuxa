<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
use Yii;
//use frontend\tests\functional\BaseUserTester;

class FolderCest 
{
    public function _before(FunctionalTester $I)
    {   
        $admin = \frontend\models\UserDb::findByUsername('admin');
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
        $I->amOnPage('folder/index');
        $I->see('Public Folder');
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

    public function createSameFolderTitle(FunctionalTester $I) 
    {
        $I->amOnPage('folder/index');
        $I->seeInCurrentUrl('folder%2Findex');
        $I->click('#plus');
        $I->fillField('#create-new-create-widget-id-title','Second folder');
        $I->click('Create');
        $I->amOnPage('folder/index');
        $I->see('Second Folder');
        $I->click('.icondesign');
        $I->fillField('#create-new-create-widget-id-title','Second folder');
        $I->click('Create');
        $I->amOnPage('folder/index');
        $I->see('Second Folder');
    }

    public function checkEmptyTitle(FunctionalTester $I) 
    {
        $I->amOnPage('folder/index');
        $I->seeInCurrentUrl('folder%2Findex');
        $I->click('#plus');
        $I->fillField('#create-new-create-widget-id-title','');
        $I->click('Create');
        $I->amOnPage('folder/index');
        $I->dontSee('.folder-text');
    } 

    public function createSubfolder(FunctionalTester $I) 
    {
         $I->amOnPage('folder/index');
         $I->seeInCurrentUrl('folder%2Findex');
         $I->click('#plus');
         $I->fillField('#create-new-create-widget-id-title','New folder');
         $I->click('Create');
         $I->amOnPage('folder/index');
         $I->click('New folder');
         $I->click('.folder-text');
         $I->fillField('#create-new-test-title','Subfolder');
         $I->click('Create');
         $I->amOnPage('folder/index');
         $I->click('New folder');
         $I->see('Subfolder');
    }

    /* public function addUsers(FunctionalTester $I) 
    {
         $I->amOnPage('folder/index');
         $I->seeInCurrentUrl('folder%2Findex');
         $I->see('test folder');
         $I->click('test folder');
         $I->click('.dropdown');
         //$I->click('.select2-search__field');
         $I->fillField('.select2-search__field','akye');
         //$I->see('OkechukwuAyke A');
    } */

}