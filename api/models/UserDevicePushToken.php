<?php
namespace api\models;

use Yii;
use common\models\UserDevicePushToken as ParentUserDevicePushToken;

/**
 * This is the model class for table "{{%user_device_push_token}}". Please note that implementation code 
 * is in the ParentParentUserDevicePushToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $push_token
 * @property int $device
 *
 * @property User $user
 */
class UserDevicePushToken extends ParentUserDevicePushToken
{

}
 