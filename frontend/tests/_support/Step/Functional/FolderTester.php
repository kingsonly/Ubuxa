<?php
namespace frontend\tests\_support\Step\Functional;

class FolderTester extends \frontend\tests\FunctionalTester
{
    /**
     *  Login function for all UserTesters. 
     *  logs in as guest if username and password are not provided. 
     *  
     *  @param [in] $userName identity username
     *  @param [in] $password identity password 
     *  @return void (logs you in)
     *  
     */
    public function haveFolder()
    {
        $I = $this;     
        $I->amOnPage('folder/index');
        $I->seeInCurrentUrl('folder%2Findex');
        $I->click('#plus');
        $I->fillField('#create-new-create-widget-id-title','New folder');
        $I->click('Create');
        $I->amOnPage('folder/index');
        $I->click('New folder');
    }

    public function refreshFolder()
    {
        $I = $this;		
        $I->amOnPage('folder/index');
        $I->click('New folder');
    }

}