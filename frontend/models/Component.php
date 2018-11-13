<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_component".
 *
 * @property int $id
 * @property int $component_template_id
 * @property string $title
 * @property string $created_at
 * @property string $last_updated
 * @property int $deleted
 * @property int $cid
 *
 * @property ComponentTemplate $componentTemplate
 * @property ComponentAttribute[] $componentAttributes
 * @property ComponentComponent[] $componentComponents
 * @property ComponentComponent[] $componentComponents0
 * @property ComponentManager[] $componentManagers
 * @property User[] $users
 * @property ComponentTask[] $componentTasks
 * @property CorrespondenceComponent[] $correspondenceComponents
 * @property Correspondence[] $correspondences
 * @property EDocumentComponent[] $eDocumentComponents
 * @property EDocument[] $edocuments
 * @property FolderComponent[] $folderComponents
 * @property Folder[] $folders
 * @property Invoice[] $invoices
 * @property InvoiceComponent[] $invoiceComponents
 * @property Invoice[] $invoices0
 * @property Order[] $orders
 * @property OrderComponent[] $orderComponents
 * @property Payment[] $payments
 * @property PaymentComponent[] $paymentComponents
 * @property Payment[] $payments0
 * @property Project[] $projects
 * @property Receivedpurchaseorder[] $receivedpurchaseorders
 * @property ReceivedpurchaseorderComponent[] $receivedpurchaseorderComponents
 * @property Receivedpurchaseorder[] $receivedpurchaseorderReferences
 */
class Component extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['component_template_id', 'deleted', 'cid'], 'integer'],
            [['created_at', 'last_updated'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['component_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponentTemplate::className(), 'targetAttribute' => ['component_template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'component_template_id' => 'Component Template ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTemplate()
    {
        return $this->hasOne(ComponentTemplate::className(), ['id' => 'component_template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentAttributes()
    {
        return $this->hasMany(ComponentAttribute::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentComponents()
    {
        return $this->hasMany(ComponentComponent::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentComponents0()
    {
        return $this->hasMany(ComponentComponent::className(), ['linked_component' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentManagers()
    {
        return $this->hasMany(ComponentManager::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('tm_component_manager', ['component_id' => 'id']);
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
    public function getCorrespondences()
    {
        return $this->hasMany(Correspondence::className(), ['id' => 'correspondence_id'])->viaTable('tm_correspondence_component', ['component_id' => 'id']);
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
        return $this->hasMany(EDocument::className(), ['id' => 'edocument_id'])->viaTable('tm_e_document_component', ['component_id' => 'id']);
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
    public function getFolders()
    {
        return $this->hasMany(Folder::className(), ['id' => 'folder_id'])->viaTable('tm_folder_component', ['component_id' => 'id']);
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
        return $this->hasMany(InvoiceComponent::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices0()
    {
        return $this->hasMany(Invoice::className(), ['id' => 'invoice_id'])->viaTable('tm_invoice_component', ['component_id' => 'id']);
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
    public function getPayments0()
    {
        return $this->hasMany(Payment::className(), ['id' => 'payment_id'])->viaTable('tm_payment_component', ['component_id' => 'id']);
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
        return $this->hasMany(Receivedpurchaseorder::className(), ['receivedpurchaseorder_reference' => 'receivedpurchaseorder_reference'])->viaTable('tm_receivedpurchaseorder_component', ['component_id' => 'id']);
    }
}
