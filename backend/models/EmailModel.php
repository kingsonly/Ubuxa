<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;


/**
 * EmailModel is the model behind the email form.
 */
class EmailModel extends Model
{
    public $subject;
    public $body;
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'body', ], 'required'],
            
        ];
    }

   
	
	

}
