<?php
namespace frontend\tests;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */
	
	public function _fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::className(),
                // fixture data located in tests/_data/userdb.php
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ];
    }

	
}
