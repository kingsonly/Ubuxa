<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface};

/**
 * This is the model class for table "tm_component_template".
 *
 * @property int $id
 * @property string $name just a public name for the customer/user
 * @property string $created_at tracking the date this template was created
 * @property string $last_update tracking the date this template was last updated
 * @property int $deleted for soft delete - DeleteUpdated does this
 * @property int $cid
 *
 * @property Component[] $components
 * @property ComponentTemplateAttribute[] $componentTemplateAttributes
 */
class ComponentTemplate extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_component_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'last_updated'], 'safe'],
            [['deleted', 'cid'], 'integer'],
            [['name'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'last_updated' => 'Last Update',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponents()
    {
        return $this->hasMany(Component::className(), ['component_template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTemplateAttributes()
    {
        return $this->hasMany(ComponentTemplateAttribute::className(), ['component_template_id' => 'id']);
    }
}
