<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Customer;
use yii\web\Session;

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
            [['cid', 'master_email', 'master_doman', 'plan_id', 'billing_date', 'account_number'], 'required'],
            [['plan_id', 'account_number'], 'integer'],
            [['billing_date'], 'safe'],
            [['cid'], 'string', 'max' => 20],
            [['master_email', 'master_doman'], 'string', 'max' => 255],
            [['master_email'], 'email'],
            ['master_email', 'unique', 'targetClass' => '\frontend\models\Customer', 'message' => 'This email address has already been taken.'],
            ['master_doman', 'unique', 'targetClass' => '\frontend\models\Customer', 'message' => 'This name has already been taken.'],
            [['cid'], 'unique'],
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
            'master_email' => 'Email',
            'master_doman' => 'Domain',
            'plan_id' => 'Select Plan',
            'billing_date' => 'Billing Date',
            'account_number' => 'Account Number',
        ];
    }

    
    public function signup($customer)
    {   
            $customer->master_email = $this->master_email;
            $customer->master_doman = $this->master_doman;
            $customer->account_number = $this->account_number;
            $customer->plan_id = $this->plan_id;
            $customer->billing_date = $this->billing_date;
            $customer->status = 0;
            $customer->cid = $this->plan_id.rand(10, 10000);
            $cid = $customer->cid;
            

            return $customer->save();
                
    }

}
