<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%component}}".
 *
 * @property integer $id
 * @property string $component_type
 * @property string $component_classname
 * @property string $component_junction
 *
 * @property ComponentTask[] $componentTasks
 * @property CorrespondenceComponent[] $correspondenceComponents
 * @property Correspondence[] $corrrespondences
 * @property EDocumentComponent[] $eDocumentComponents
 * @property EDocument[] $edocuments
 * @property FolderComponent[] $folderComponents
 * @property Folder[] $tycRefs
 * @property Invoice[] $invoices
 * @property InvoiceComponent[] $invoiceComponents
 * @property Order[] $orders
 * @property OrderComponent[] $orderComponents
 * @property Payment[] $payments
 * @property PaymentComponent[] $paymentComponents
 * @property Project[] $projects
 * @property Receivedpurchaseorder[] $receivedpurchaseorders
 * @property ReceivedpurchaseorderComponent[] $receivedpurchaseorderComponents
 * @property Receivedpurchaseorder[] $receivedpurchaseorderReferences
 */
class Component extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%component}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['component_type', 'component_classname', 'component_junction'], 'required'],
            [['component_type'], 'string'],
            [['component_classname', 'component_junction'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'component_type' => 'Component Type',
            'component_classname' => 'namespaced full classname',
            'component_junction' => 'component to component table for this component',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTasks()
    {
        return $this->hasMany(ComponentTask::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorrespondenceComponents()
    {
        return $this->hasMany(CorrespondenceComponent::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorrrespondences()
    {
        return $this->hasMany(Correspondence::className(), ['id' => 'corrrespondence_id'])->viaTable('{{%correspondence_component}}', ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEDocumentComponents()
    {
        return $this->hasMany(EDocumentComponent::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdocuments()
    {
        return $this->hasMany(EDocument::className(), ['id' => 'edocument_id'])->viaTable('{{%e_document_component}}', ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolderComponents()
    {
        return $this->hasMany(FolderComponent::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTycRefs()
    {
        return $this->hasMany(Folder::className(), ['tyc_ref' => 'tyc_ref'])->viaTable('{{%folder_component}}', ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceComponents()
    {
        return $this->hasMany(InvoiceComponent::className(), ['componenet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderComponents()
    {
        return $this->hasMany(OrderComponent::className(), ['componenet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentComponents()
    {
        return $this->hasMany(PaymentComponent::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedpurchaseorders()
    {
        return $this->hasMany(Receivedpurchaseorder::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedpurchaseorderComponents()
    {
        return $this->hasMany(ReceivedpurchaseorderComponent::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedpurchaseorderReferences()
    {
        return $this->hasMany(Receivedpurchaseorder::className(), ['receivedpurchaseorder_reference' => 'receivedpurchaseorder_reference'])->viaTable('{{%receivedpurchaseorder_component}}', ['component_id' => 'id']);
    }
	
	public function getComponentItem() 
	{
		$class = $this->component_classname;
		$tableName = $class::tableName();
		return $class::findOne(["{$tableName}.component_id" => $this->id]);
	}
}
