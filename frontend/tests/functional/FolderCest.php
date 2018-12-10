<?php 
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;


class FolderCest{

	public function _fixtures()
	{
	    return [
	        'user' => [
	            'class' => UserFixture::className(),
	            'dataFile' => codecept_data_dir() . 'login_data.php'
	        ]
	    ];
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
    	$I->amOnPage('site/login');
        $I->submitForm('#login-form', $this->formParams('flash', 'password'));
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }



   public function createFolder(FunctionalTester $I)
   {	
    	$I->amOnRoute('folder/index');
    	//$I->click('.plus');
    	//$I->fillField('name', 'New folder');
    	
   }
}