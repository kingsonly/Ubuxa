<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
//use frontend\tests\functional\BaseUserTester;

class TaskCest 
{
    public function _before(FunctionalTester $I)
    {
       
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    
    public function tryToTest(FunctionalTester $I)
    {
        
         $I->amOnRoute('folder/index');
         $I->seeInCurrentUrl('folder/index');
         //$I->see('login');
    }
}