<?php
namespace frontend\tests\functional;

class BaseUserTester extends \frontend\tests\FunctionalTester
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
    public function login($userName = NULL, $password = NULL)
    {
        $I = $this;
		
		if ( empty($userName) || empty($password) ) {
			$userName = 'guest';
			$password = 'guest##99';
		} 		
		
		$I->amOnPage('/site/login');
		$I->fillField('#loginform-username', $userName);
        $I->fillField('#loginform-password', $password);
        $I->click('Login');
		//$I->wait(500);
        return $I;
    }

}