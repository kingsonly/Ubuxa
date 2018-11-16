<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;


/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property string $cid a value to programmatically generate
 * @property string $master_email
 * @property string $master_doman
 * @property int $plan_id
 * @property string $billing_date
 * @property int $account_number a public account id should be 6 digits (1m) 
 */
class Customer extends \yii\db\ActiveRecord
{
    

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
            [['cid', 'master_email', 'master_doman', 'plan_id', 'billing_date', 'account_number','entity_id'], 'required'],
            [['plan_id', 'account_number','entity_id'], 'integer'],
            [['billing_date'], 'safe'],
            [['cid'], 'string', 'max' => 20],
            [['master_email', 'master_doman'], 'string', 'max' => 255],
            [['master_email'], 'email'],
            ['master_email', 'unique', 'message' => 'This email address has already been taken.'],
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
            'entity_id' => 'Entity Id',
            'master_email' => 'Master Email',
            'master_doman' => 'Master Doman',
            'plan_id' => 'Plan ID',
            'billing_date' => 'Billing Date',
            'account_number' => 'Account Number',
        ];
    }


}
