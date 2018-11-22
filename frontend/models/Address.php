<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface};
/**
 * This is the model class for table "{{%tm_address}}".
 *
 * @property integer $id
 * @property string $address_line
 * @property string $state
 * @property string $Country
 * @property string $code
 *
 * @property TmAddressCorporation[] $tmAddressCorporations
 */
class Address extends BoffinsArRootModel implements TenantSpecific
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid'], 'required'],
            [['address_line', 'code'], 'safe'],
            [['address_line', 'code'], 'string', 'max' => 255],		
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address_line' => 'Address ',
            'state' => 'State',
            'country' => 'Country',
            'code' => 'Zip/Postal Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressCorporations()
    {
        return $this->hasMany(AddressCorporation::className(), ['address_id' => 'id']);
    }
}
