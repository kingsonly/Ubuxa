<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property int $entity_id
 * @property string $cid a value to programmatically generate
 * @property string $master_email
 * @property string $master_doman
 * @property int $plan_id
 * @property string $billing_date
 * @property int $account_number a public account id should be 6 digits (1m) 
 * @property int $has_admin
 *
 * @property Entity $entity
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    Const NO_ADMIN = 0;
    Const HAS_ADMIN = 1;
    Const CORPORATION = 'corporation';
    Const PERSON = 'person';
    
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
            [['entity_id', 'cid', 'master_email', 'master_doman', 'billing_date', 'account_number'], 'required'],
            [['entity_id', 'plan_id', 'account_number', 'has_admin'], 'integer'],
            [['billing_date', 'plan_id'], 'safe'],
            [['cid'], 'string', 'max' => 20],
            [['master_email', 'master_doman'], 'string', 'max' => 255],
            [['cid'], 'unique'],
            [['entity_id'], 'exist', 'skipOnError' => true, 'targetClass' => TenantEntity::className(), 'targetAttribute' => ['entity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
            'cid' => 'Cid',
            'master_email' => 'Email',
            'master_doman' => 'Domain Name',
            'plan_id' => 'Plan ID',
            'billing_date' => 'Billing Date',
            'account_number' => 'Account Number',
            'has_admin' => 'Has Admin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(TenantEntity::className(), ['id' => 'entity_id']);
    }

    public function getCorporation()
    {
        return $this->hasOne(TenantCorporation::className(), ['entity_id' => 'id'])->via('entity');
    }

    public function getCorporationName()
    {
        return $this->corporation->name;
    }

    public function getEntityName()
    {
        return $this->entity->entity_type;
    }
	
	public function sendEmail($newCustomerEmail,$registrationLink)
    {
        return Yii::$app->mailer->compose(['html' => 'newcustomer'],
                [
                    'link'  => $registrationLink,
                ])
            ->setTo($newCustomerEmail)
            ->setFrom(['support@test.ubuxa.net' => 'Ubuxa.net'])
            ->setSubject('Thanks for joining Ubuxa')
            ->send();
    }
	
	public function sendEmailToken($newCustomerEmail,$token)
    {
        return Yii::$app->mailer->compose(['html' => 'newcustomertoken'],
                [
                    'token'  => $token,
                ])
            ->setTo($newCustomerEmail)
            ->setFrom(['support@test.ubuxa.net' => 'Ubuxa.net'])
            ->setSubject('Ubuxa Email Verification Token')
            ->send();
    }


    public static function checkDomain($subdomain)
    {
        $customer = [];
        $model = self::find()->where(['master_doman' => $subdomain]);
        $domain = $model->exists();
        array_push($customer, $domain);
        if ($domain) {
            $findTenant = $model->one();
            if ($findTenant->entityName == self::CORPORATION) {
                array_push($customer, ucfirst($findTenant->corporationName));
            }else{
                array_push($customer, ucfirst($findTenant->master_doman));
            }
        }
        return $customer;
    }
}
