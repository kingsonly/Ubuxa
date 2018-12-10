<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
use frontend\tests\functional\BaseUserTester;

class TaskCest 
{
    public function _before(BaseUserTester $I)
    {
        $I->login('guest','guest##99');
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        
        $I->amOnRoute('folder/index');
        $I->see('.plus');
    }
}
