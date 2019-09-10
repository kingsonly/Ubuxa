<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;

class LoginCest 
{
     /**
      * Load fixtures before db transaction begin
      * Called in _before()
      * @see \Codeception\Module\Yii2::_before()
      * @see \Codeception\Module\Yii2::loadFixtures()
      * @return array
      */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    public function _before(FunctionalTester $I)
    {
        
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    
    public function checkValidLogin(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->fillField('#loginform-username','guest');
        $I->fillField('#loginform-password','guest##99');
        $I->click('Log In');
        //$I->see('#w0','Invalid login details');
        $I->dontSeeLink('Sign up');
        $I->seeInCurrentUrl('folder');
    }
}
