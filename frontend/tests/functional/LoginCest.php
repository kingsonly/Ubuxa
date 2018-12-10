<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;

class LoginCest extends \frontend\tests\FunctionalTester
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
        $I->amOnRoute('site/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    
    public function checkValidLogin($userName = NULL, $password = NULL)
    {
        $I = $this;
        $I->fillField('#loginform-username','$userName');
        $I->fillField('#loginform-password','$password');
        $I->click('Login');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
