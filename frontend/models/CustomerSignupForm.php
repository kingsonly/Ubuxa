<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Customer;
use frontend\models\Email;
use yii\web\Session;
use yii\helpers\Url;


/**
 * Signup form
 */
class CustomerSignupForm extends Model
{


    public $cid;
    public $master_email;
    public $master_doman;
    public $plan_id;
    public $account_number;
    public $billing_date;
    public $entity_id;
    public $isNewRecord = true;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_tenant');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cid', 'master_email', 'master_doman', 'plan_id', 'billing_date', 'account_number', 'entity_id'], 'required'],
            [['plan_id', 'account_number','entity_id'], 'integer'],
            [['billing_date'], 'safe'],
            [['cid'], 'string', 'max' => 20],
            [['master_email', 'master_doman'], 'string', 'max' => 255],
            [['master_email'], 'email'],
            ['master_email', 'checkUniq'],
            ['master_doman', 'unique', 'targetClass' => '\frontend\models\Customer', 'message' => 'This name has already been taken.'],
            [['cid'], 'unique'],
            [['entity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entity::className(), 'targetAttribute' => ['entity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'entity_id' => 'Entity Id',
            'master_email' => 'Email',
            'master_doman' => 'Domain',
            'plan_id' => 'Select Plan',
            'billing_date' => 'Billing Date',
            'account_number' => 'Account Number',
        ];
    }

    private function generateRandomCid()
    {
        $rand = rand(10, 100000);
        $checkRand = Customer::find()->where(['cid'=>$rand])->exists();
        if (!$checkRand) {
            return $rand;
        }else{
            $this->generateRandomCid();
        }
    }

    private function generateRandomAccount()
    {
        $randacc = rand(10, 100000);
        $checkRand = Customer::find()->where(['account_number'=>$randacc])->exists();
        if (!$checkRand) {
            return $randacc;
        }else{
            $this->generateRandomAccount();
        }
    }

    
    public function signup($customer)
    {   
            $customer->master_email = $this->master_email;
            $customer->master_doman = $this->master_doman;
            $customer->account_number = $this->plan_id.$this->generateRandomAccount(); //dummy account number
            $customer->plan_id = $this->plan_id;
            $customer->billing_date = $this->billing_date;
            $customer->entity_id = $this->entity_id;
            $customer->has_admin = 0;
            $customer->cid = $this->plan_id.$this->generateRandomCid(); //dummy cid
            if($customer->save()){
				return $customer->cid;
			}
                
    }

    public function checkUniq()
    {
        $uniq = Customer::find()->where(['master_email'=>$this->master_email])->exists();
        $userExists = Email::find()->where(['address'=>$this->master_email])->exists();
        if($uniq && $userExists){
            $this->addError('master_email', 'This email already exist. <a href="'.Url::to(["site/request-password-reset"]).'">Forgot your password?</a>');
        }elseif ($uniq && !$userExists) {
            $this->addError('master_email', 'This email already exist. <a href="#resend-invite" class="resend-invite">Resend Verification link?</a>');
        }
        
    }

    
    /*public function clientValidateAttribute($model, $attribute, $view)
    {
    
    $uniq = self::find()->where(['master_email'=>$this->master_email])->one();
    if (count($uniq)==1){
        
            return <<<JS
            deferred.push(messages.push('test'));
    JS;
        }
        
    }*/



}
