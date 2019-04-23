<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\User;
use frontend\models\Email;
use frontend\models\EmailEntity;

/**
 * Password reset request form
 */
class UserSearch extends Model
{
    public $search_string;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            ['search_string', 'required'],
          
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
   
}
