<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_invoice_component".
 *
 * @property integer $invoice_id
 * @property integer $componenet_id
 *
 * @property TmInvoice $invoice
 * @property TmComponent $componenet
 */
class InvoiceComponent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice_component}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'componenet_id'], 'required'],
            [['invoice_id', 'componenet_id'], 'integer'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
            [['componenet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Component::className(), 'targetAttribute' => ['componenet_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => 'Invoice ID',
            'componenet_id' => 'Componenet ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponenet()
    {
        return $this->hasOne(Component::className(), ['id' => 'componenet_id']);
    }
}
