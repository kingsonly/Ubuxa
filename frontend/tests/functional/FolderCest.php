<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
use frontend\tests\_support\Step\Functional\FolderTester;
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

    public function createSubfolder(FolderTester $I) 
    {   
        $I->haveFolder();
        $I->click('.folder-text');
        $I->fillField('#create-new-test-title','Subfolder');
        $I->click('Create');
        $I->refreshFolder();
        $I->see('Subfolder');
    }

    public function addUsers(FolderTester $I) 
    {    
        $I->haveFolder();
        $I->click('.glyphicon-plus-sign');
        //$I->seeElement('.select2-search__field');
        //$I->click('.select2-search__field');
        //$I->fillField('.select2-search__field','akye');
        //$I->see('OkechukwuAyke A');
    }

}