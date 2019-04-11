<?php
namespace api\models;

use yii\base\Model;
use Yii;


/**
 * Signup form
 */
class ValidateEmail extends Model
{
    public $validation_code;
   


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['validation_code'],'required'],
            
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
   
	
	public function validateEmail(){
		if (!$this->validate()) {

            Yii::$app->api->sendFailedResponse($this->errors);
            //return null;
        }
		$model = new ValidationKey();
        $checkIfCodeIsValid = $model->find()->andWhere(['key_code' => $this->validation_code])->one();
		return $checkIfCodeIsValid;
	}
}
