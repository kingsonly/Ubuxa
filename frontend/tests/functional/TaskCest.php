<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
use \Codeception\Util\Locator;
//use frontend\tests\functional\BaseUserTester;

class TaskCest 
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $admin = \frontend\models\UserDb::findByUsername('guest');
        $I->amLoggedInAs($admin);
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function goToKanban(FunctionalTester $I){
         $I->amOnRoute('folder/view', ['id' => 15]);
         $I->seeInCurrentUrl('folder%2Fview');
         $I->seeElement('.menu-icon');
         $I->click('.menu-icon');
         $I->seeElement('.open-board');
         $I->click('.open-board');
         $I->see('add loader image');
    }
    
    public function createTask(FunctionalTester $I)
    {
         $I->amOnPage('folder/index');
         $I->seeInCurrentUrl('folder%2Findex');
         $I->see('test folder');
         $I->click('test folder');
         $I->fillField('#addTask','test task again');
         $I->click('#taskButton');
         $I->amOnRoute('folder/view', ['id' => 15]);
         $I->seeInCurrentUrl('folder%2Fview');
         $I->see('test task again');
        
    }

    public function checkTaskCompleted(FunctionalTester $I)
    {
         $this->createTask($I);
         $I->seeElement('.todo_listt6');
         $I->click('.todo_listt6');
         $I->amOnRoute('folder/view', ['id' => 15]);
         $I->dontSeeElement('.checked6');
         /*$I->amOnRoute('folder/view', ['id' => 15]);
         $I->seeInCurrentUrl('folder%2Fview');
         $I->see('#todo-list24','checked');*/
        
    }

    
    public function createTaskOnKanban(FunctionalTester $I)
    {
         $this->goToKanban($I);
         $I->seeElement('.add-card');
         $I->click('.add-card');
         $I->seeElement('.cardInput');
         $I->fillField('.cardInput','Kanban Task');
         $I->click('Add Task','button');
         $this->goToKanban($I);
         $I->see('Kanban Task');

    }

    public function deleteTaskOnKanban(FunctionalTester $I)
    {
         $this->createTaskOnKanban($I);
         $I->click( '.fa-trash' );
         $I->click( '#delete-task1' );
         $this->goToKanban($I);
         $I->dontSee('Kanban Task');

    }

    public function createTaskLabelOnKanban(FunctionalTester $I)
    {
         $this->goToKanban($I);
         $I->click( '.fa-tags' );
         $I->fillField( '#testing-11', 'urgent test');
         $I->click( '#checkb11');
         $this->goToKanban($I);
         $I->see('urgent test');
    }


}