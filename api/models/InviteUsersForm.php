<?php

namespace api\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;


/**
 * ContactForm is the model behind the contact form.
 */
class InviteUsersForm extends Model
{
    public $email;
    public $subject;
    public $body;
    public $role;
    public $folder;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email', 'subject', 'body', 'role'], 'required'],
            [['folder'], 'safe'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
	
	// this is a better way to send an email
	public function sendEmail($emails,$roles,$folderId)
    {
		
		// $cid = Yii::$app->user->identity->cid;
  //       $emails[] = $this->email;
  //       $roles = $this->role;
		// foreach ($emails as $email) {
  //            ($role=="Administrator")?$role=1:($role=="Data Entry")?$role=2:($role=="Field Officer")?$role=3:$role=0;
  //           if($folderId==0){
		// 	Yii::$app->mailer->compose(['html' => 'inviteusers'],
  //               [
  //                   //'body'  => $this->body,
  //                   'link'  => 'http://'.yii::$app->user->identity->masterDomain.'.ubuxa.net'.Url::to(['site/signup','email'=> $email,'cid'=>$cid,'role' => $role])
  //               ])
  //               ->setTo($email)
  //               ->setFrom([\Yii::$app->params['supportEmail'] => 'Ubuxa'])
  //               ->setSubject('Ubuxa Invite')
  //               ->send();
  //           } else {
  //            Yii::$app->mailer->compose(['html' => 'inviteusers'],
  //               [
  //                   //'body'  => $this->body,
  //                   'link'  => 'http://'.yii::$app->user->identity->masterDomain.'.ubuxa.net'.Url::to(['site/signup','folderid'=>empty($folderId)?0:$folderId,'email'=> $email,'cid'=>$cid,'role' => $role])
  //               ])
  //               ->setTo($email)
  //               ->setFrom([\Yii::$app->params['supportEmail'] => 'Ubuxa'])
  //               ->setSubject('Ubuxa Invite')
  //               ->send();
  //           }
            
		// }
		// return true;

        $cid = Yii::$app->user->identity->cid;
        foreach ($emails as $index=>$email) {
            Yii::$app->mailer->compose(['html' => 'inviteusers'],
                [
                    //'body'  => $this->body,
                    'link'  => 'http://'.yii::$app->user->identity->masterDomain.'.ubuxa.net/index.php?r=site/signup&folderid='.$folderId.'&email='.$email.'&cid='.$cid.'&role='.$roles[$index],
                ])
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Ubuxa'])
            ->setSubject('Ubuxa Invite')
            ->send();
        }
        return true;
    }

}
