<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
use \Codeception\Util\Locator;
//use frontend\tests\functional\BaseUserTester;

class EdocumentCest 
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $admin = \frontend\models\UserDb::findByUsername('guest');
        $I->amLoggedInAs($admin);
        $I->amOnPage('folder/index');
        $I->seeInCurrentUrl('folder/index');
        $I->amOnRoute('folder/view', ['id' => 14]);
    }

    public function _after(FunctionalTester $I)
    {
    }
    
    public function folderDocs(FunctionalTester $I)
    {
        $I->click('.edoc-label');
        $I->see('Folder Files');
        $I->click('Add attachments');
        //$I->click('#dropuploadfolderUpload');
        $I->attachFile('input[type="hidden"]', 'user.php');
    }

}