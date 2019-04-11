<?php
namespace api\models;

use yii\base\Model;
use common\models\User;
use Yii;
use frontend\models\Customer;
use frontend\models\CustomerSignupForm;
use frontend\models\TenantEntity;
use frontend\models\TenantCorporation;
use frontend\models\TenantPerson;
use frontend\models\UserSetting;
use yii\db\Expression;

/**
 * Signup form
 */
class CustomerSignup extends Model
{
    public $master_doman;
    public $master_email;
    public $account_type;
    public $corporation_name;
    public $first_name;
    public $surname;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['master_email','master_doman','account_type'],'required'],
            [['corporation_name','first_name','surname'],'safe'],
            ['master_email', 'trim'],
            ['master_doman', 'trim'],
            ['master_doman', 'unique', 'targetClass' => 'frontend\models\Customer', 'message' => 'This domain has already bn taken has already been taken.'],
            ['master_email', 'string', 'min' => 2, 'max' => 255],
            ['master_doman', 'string', 'min' => 2, 'max' => 255],
            ['master_email', 'string', 'max' => 255],
            ['master_email', 'unique', 'targetClass' => 'frontend\models\Customer', 'message' => 'This email address has already been taken.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
   
	
	public function signup(){
		if (!$this->validate()) {

            Yii::$app->api->sendFailedResponse($this->errors);
            //return null;
        }
		
		$customerModel = new Customer();
       	$customer = new CustomerSignupForm();
       	$tenantEntity = new TenantEntity();
       	$tenantCorporation = new TenantCorporation();
       	$tenantPerson = new TenantPerson();
		$settings = new UserSetting();
		
		$settings->logo = Yii::$app->settingscomponent-> boffinsDefaultLogo();
		$settings->theme = Yii::$app->settingscomponent->boffinsDefaultTemplate();
		$settings->language = Yii::$app->settingscomponent->boffinsDefaultLanguage();
		$settings->date_format = Yii::$app->settingscomponent->boffinsDefaultDateFormart();
		
		$tenantEntity->entity_type = $this->account_type;
		$customer->master_doman = $this->master_doman;
		$customer->master_email = $this->master_email;
		$tenantPerson->first_name = $this->first_name;
		$tenantPerson->surname = $this->surname;
		$tenantCorporation->name = $this->corporation_name;
        if (!empty($tenantEntity->entity_type) && !empty($customer->master_doman)) {
			
        	$email = $customer->master_email;
        	$date = strtotime("+7 day");
        	$customer->billing_date = date('Y-m-d', $date);
        	
        	
        	if($tenantEntity->save()){
        		if($tenantEntity->entity_type == TenantEntity::TENANTENTITY_PERSON){
        				$tenantPerson->entity_id = $tenantEntity->id;
        				$tenantPerson->create_date = new Expression('NOW()');
        				$tenantPerson->save(false);

        		}elseif ($tenantEntity->entity_type == TenantEntity::TENANTENTITY_CORPORATION) {
						$tenantCorporation->attributes = $this->request;
        				$tenantCorporation->entity_id = $tenantEntity->id;
        				$tenantCorporation->create_date = new Expression('NOW()');
        				$tenantCorporation->save(false);

        		}
        		$customer->entity_id = $tenantEntity->id;
	        	if($customer->signup($customerModel)){ 
	        		$settings->tenantID = (int)$customerModel->cid;
					if($settings->save()){
						$registrationLink = 'http://'.$customer->master_doman.'.ubuxa.net'.\yii\helpers\Url::to(['site/signup','cid' => $customerModel->cid, 'email' => $email, 'role' => 1]);
						$validateKeyModel = new ValidationKey();
						$validateKeyModel->key_code = rand(10, 10000);;
						$validateKeyModel->customer_id = $customerModel->cid;
						
						if($validateKeyModel->save()){
							if($customerModel->sendEmailToken($email,$validateKeyModel->key_code)){
							 	Yii::$app->api->sendSuccessResponse($customer->attributes);
							} else{
								Yii::$app->api->sendFailedResponse("Invalid Request");
							}
						}
						
					}
	        	}
	        }
		}else{
			Yii::$app->api->sendFailedResponse("every thing is empty");
		}
	}
}
