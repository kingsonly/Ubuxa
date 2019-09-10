<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;


/**
 * EmailModel is the model behind the email form.
 */
class SearchModel extends Model
{
    public $date_from;
    public $date_to;
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to', ], 'required'],
            
        ];
    }

   
	
	

}
