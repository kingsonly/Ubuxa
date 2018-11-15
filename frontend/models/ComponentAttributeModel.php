<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ComponentAttributeModel extends Model
{
    public $attributeId;
    public $value;
		
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['attributeId', 'value'], 'required'],
            // email has to be a valid email address
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attributeId' => '',
            'value' => '',
        ];
    }

}
