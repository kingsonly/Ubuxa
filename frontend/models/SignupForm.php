<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
/**
 * Signup form
 */
class SignupForm extends Model
{
    
    //person model attributes
    public $first_name;
    public $surname;
    //public $dob;
    
    //user model attributes 
    public $username;
    public $password;
    public $password_repeat;
    public $basic_role;
    
    //telephone model attributes
    //public $telephone_number;
    
    //email model attributes
    public $address;
    
    //address model attributes
    //public $address_line;
    public $state_id;
    public $country_id;
    //public $code;
    public $cid;

    public $isNewRecord = false; //to mimic AR
    
    private $_personAR = false;
    private $_userAR = false;
    private $_telephoneAR = false;
    private $_emailAR = false;
    private $_addressAR = false;
    
    
    public function __construct($username = '', $config=[])
    {
        parent::__construct($config);
        if (!empty($username)) {
            $this->_userAR = UserDb::findByUsername($username);
            
            if ( empty($this->_userAR) ) {
                $this->_initialiseNew();
                parent::__construct($config);
                return;
            }

            $this->_personAR = Person::findOne($this->_userAR->person_id);
                                    
            $entity_id = empty($this->_personAR) ? $this->_getNewEntity()->id : $this->_personAR->entity_id;

           /* $this->_telephoneAR = ( ($TE = TelephoneEntity::findOne(['entity_id' => $entity_id])) != NULL ) ? 
                                    Telephone::findOne( ['id' => $TE->telephone_id] ) : 
                                    new Telephone; */
            $this->_emailAR = ( ($EE = EmailEntity::findOne(['entity_id' => $entity_id])) != NULL ) ? 
                                Email::findOne( ['id' => $EE->email_id] ) : 
                                new Email;
            /* $this->_addressAR = ( ($AE = AddressEntity::findOne(['entity_id' => $entity_id])) != NULL ) ?
                                Address::findOne( ['id' => $AE->address_id] ) : 
                                new Address; */   
            
            $attributes = $this->_userAR->getAttributes();
            if ( !empty($this->_personAR) ) {
                $attributes = array_merge( $attributes, $this->_personAR->getAttributes() );
            } else {
                trigger_error('User created without person?? ' . __METHOD__);
            }

            /* if ( !$this->_telephoneAR->isNewRecord ) {
                $attributes += $this->_telephoneAR->getAttributes();
            } */

            if ( !$this->_emailAR->isNewRecord ) {
                $attributes += $this->_emailAR->getAttributes();
            } 

           /* if ( !$this->_addressAR->isNewRecord ) {
                $attributes += $this->_addressAR->getAttributes();
            } */
            //echo '<pre>'; var_dump($attributes);
            $this->load($attributes);
        } else {
            $this->_initialiseNew();
        }
    }
    
    private function _getNewEntity() {
        $_entityAR = new Entity;
        $_entityAR->entity_type = Entity::ENTITY_PERSON;
        $_entityAR->cid = $this->cid;
        return $_entityAR->save(false) ? $_entityAR: trigger_error('Could not create a new Entity for unknown reason', E_USER_NOTICE);
    }
    
    private function _initialiseNew()
    {
        $this->isNewRecord = true;
        $this->_personAR = new Person;
        $this->_userAR = new UserDb;
        //$this->_telephoneAR = new Telephone;
        $this->_emailAR = new Email;
        //$this->_addressAR = new Address;
    }
    
    public function formName() 
    {
        return '';
    }
    
        public function attributeLabels()
    {
        return [
                'address' => 'Email Address',
                //'address_line' => 'Address',
                //'code' => 'Zip/Post Code',
                'state_id' => 'State',
                'country_id' => 'Country',
                //'dob' => 'Date of Birth',
                'cid' => 'Cid',
            ];
    }

    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['first_name', 'surname', 'username', 'password'], 'required'],
            // attributes must be a string value
            [['first_name', 'surname', 'username'], 'string'],
            [['password'], 'string', 'min' => 6],
            //[['password_repeat'], 'required'],
            [['password_repeat'], 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
            //attributes should be loaded onto model - safe            
            [[/* 'telephone_number', 'address_line', */'state_id','dob','address','basic_role', 'country_id', 'code', 'cid'], 'safe'],
            ['username', 'unique', 'targetClass' => '\frontend\models\UserDb', 'message' => 'This username has already been taken.'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     */
    public function validatePassword($attribute, $params)
    {
        //Kingsley to rewrite to ensure strong passwords
        return !empty($this->password);
    }
    
    private function _beforeSave()
    {
        if ($this->isNewRecord) {           
            return $this->_saveAsNew();
        } else {
            return $this->_saveAsExisting();
        }       
    }
    
    private function _saveAsNew()
    {
        $processFails = false;
        $transaction = Yii::$app->db->beginTransaction();
        $_entityAR = new Entity;
        $_entityAR->entity_type = Entity::ENTITY_PERSON;
        $_entityAR->cid = $this->cid;
        $processFails = $_entityAR->save(false) ? false : true;
        
        if ($processFails) {
            $transaction->rollBack();
            return false;
        }
        
        $entity_id = $this->isNewRecord && $_entityAR->save(false) ? $_entityAR->id : $this->_personAR->entity_id;
        
        
        //process addresses
        /* $this->_addressAR->setAttributes($this->getAttributes(), true);
        if ( $this->_addressAR->save(false) ) {
            $addressEntity = new AddressEntity;
            $addressEntity->address_id = $this->_addressAR->id ;
            $addressEntity->entity_id = $entity_id;
            $processFails = $addressEntity->save(false) ? $processFails && true : true;
        } else {
            $processFails = true;   //redundant 
            $transaction->rollBack();
            return false;
        } */
        
        //process telephone 
        /* $this->_telephoneAR->setAttributes($this->getAttributes(), true);
        if ( !$processFails && $this->_telephoneAR->save(false) ) {
            $telephoneEntity = new TelephoneEntity;         
            $telephoneEntity->telephone_id = $this->_telephoneAR->id;
            $telephoneEntity->entity_id = $entity_id;
            $processFails = $telephoneEntity->save(false) ? $processFails && true : true;
        } else {
            $processFails = true;   //redundant 
            $transaction->rollBack();
            return false;
        } */
        
        //process emails
        $this->_emailAR->setAttributes($this->getAttributes(), true);
        if ( !$processFails && $this->_emailAR->save(false) ) {
            $emailEntity = new EmailEntity;         
            $emailEntity->email_id = $this->_emailAR->id;
            $emailEntity->entity_id = $entity_id;
            $processFails = $emailEntity->save(false) ? $processFails && true : true;
        } else {
            $processFails = true;   //redundant 
            $transaction->rollBack();
            return false;
        }
        //process person
        $this->_personAR->setAttributes($this->getAttributes(), true);
        $this->_personAR->entity_id = $entity_id;           
        $processFails = $this->_personAR->save(false) ? $processFails && true : true;
        
        if ($processFails) {
            $transaction->rollBack();
            return false;
        } else {
            //process users
            $transaction->commit();
            $this->_userAR->person_id = $this->_personAR->id;
            $this->_userAR->setAttributes($this->getAttributes(), true);
        }
        
        return !$processFails && $this->_save();
    }
    
    private function _saveAsExisting()
    {
        $processFails = false;
        $transaction = Yii::$app->db->beginTransaction();
        if ( empty($this->_personAR->entity_id) ) {
            trigger_error("Can't save as existing without a person " . __METHOD__);
        }
        
        //process person
        $entity_id = $this->_personAR->entity_id;
        $this->_personAR->setAttributes($this->getAttributes(), true);
        $processFails = $this->_personAR->save(false) ? $processFails && true : true;
        
        //process Addresses
        /*
        $this->_addressAR->setAttributes($this->getAttributes(), true);
        if ( $this->_addressAR->isNewRecord && !$processFails ) {
            $processFails = $this->_addressAR->save(false) ? $processFails && true : true;
            $_addressEntity = new AddressEntity;
            $_addressEntity->address_id = $this->_addressAR->id;
            $_addressEntity->entity_id = $entity_id;
            $processFails = !$processFails && $_addressEntity->save(false) ? false : true;
        } elseif (!$processFails) {
            $processFails = $this->_addressAR->save(false) ? $processFails && true : true;
        }         
        //process Telephone
        $this->_telephoneAR->setAttributes($this->getAttributes(), true);
        if ( $this->_telephoneAR->isNewRecord && !$processFails ) {
            $processFails = $this->_telephoneAR->save(false) ? $processFails && true : true;
            $_telephoneEntity = new TelephoneEntity;
            $_telephoneEntity->telephone_id = $this->_telephoneAR->id;
            $_telephoneEntity->entity_id = $entity_id;
            $processFails = $_telephoneEntity->save(false) ? $processFails && true : true;
        } elseif (!$processFails) {
            $processFails = $this->_telephoneAR->save(false) ? $processFails && true : true;
        } */
        
        //process Email
        $this->_emailAR->setAttributes($this->getAttributes(), true);
        if ( $this->_emailAR->isNewRecord && !$processFails ) {
            $processFails = $this->_emailAR->save(false) ? $processFails && true : true;
            $_emaiEntity= new EmailEntity;
            $_emaiEntity->email_id = $this->_emailAR->id;
            $_emaiEntity->entity_id = $entity_id;
            $processFails = $_emaiEntity->save(false) ? $processFails && true : true;
        } elseif (!$processFails) {
            $processFails = $this->_emailAR->save(false) ? $processFails && true : true;
        }
        
        if ($processFails) {
            $transaction->rollBack();
        } else {
            //process users
            $transaction->commit();
            $this->_userAR->person_id = $this->_personAR->id;
            $this->_userAR->setAttributes($this->getAttributes(), true);
        }
        return !$processFails && $this->_save();
    }
    
    public function getState() 
    {
        return $this->state_id;
    }
    
    public function getCountry() 
    {
        return $this->country_id;
    }
    
    public function save($validate = true)
    {
        return $validate ? $this->validate() && $this->_beforeSave() : $this->_beforeSave();
    }

    private function _save() 
    {
        $transaction = Yii::$app->db->beginTransaction();
        if ( $this->_userAR->save() ) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollBack();
            $this->_reverseAll();
            return false;
        }
    }
    
    private function _reverseAll() {
        //$this->_telephoneAR->delete();
        $this->_emailAR->delete();
        //$this->_addressAR->delete();
        $this->_personAR->delete();
        $this->_entityAR->delete();
    }
    
    public function getId() 
    {
        return $this->_userAR->id;
    }

    public function checkUniq($attribute, $params)
    {
        $uniq = self::find()->where(['username'=>$this->username])->one();
        if (count($uniq)==1){
            $this->addError('username', 'This username already exist.');
        }
        
    }
    
    public function clientValidateAttribute($model, $attribute, $view)
    {
    
    $uniq = self::find()->where(['username'=>$this->username])->one();
    if (count($uniq)==1){
        
        return <<<JS
        deferred.push(messages.push('test'));
JS;
    }
    
}
    
}

