<?php
namespace frontend\tests;

use Yii;
use frontend\models\LoginForm;

class TaskTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $model = new LoginForm([
            'username' => 'guest',
            'password' => 'guest##99',
        ]);
 
        //$this->specify('user should be able to login with correct credentials', function () use ($model) {
            expect('model should login user', $model->login())->true();
            expect('error message should not be set', $model->errors)->hasntKey('password');
            expect('user should be logged in', Yii::$app->user->isGuest)->false();
        //});
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        // insert records in database
        $this->tester->haveRecord('frontend\models\Task', ['title' => 'davert']);
        // check records in database
        $this->tester->seeRecord('frontend\models\Task', ['title' => 'davert']);
    }
}