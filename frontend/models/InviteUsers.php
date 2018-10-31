<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class InviteUsers extends Model
{
    public $users;
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['users'], 'safe'],
           
        ];
    }

}
