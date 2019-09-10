<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
use \Codeception\Util\Locator;
//use frontend\tests\functional\BaseUserTester;

class OnboardingCest 
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
    
    public function taskOnboarding(FunctionalTester $I)
    {
          $I->click('#task-tipz');
          $I->click('#task-tour');
          $I->click('.close');
    }

}