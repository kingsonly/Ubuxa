<? 
$getAllNotifications = $model->find()->where(['receivers_id' => yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->all();
foreach($getAllNotifications as $key => $value){ ?>
	<? $image = !empty($value->sender->profile_image)?$value->sender->profile_image:'images/users/default-user.png'; ?>
	<li class="notificationbox" data-username="<?= $value->sender->username;?>" data-fullname="<?= $value->sender->fullname;?>" data-foldertitle="<?= $value->folder->title;?>" data-folderid="<?= $value->folder->id;?>" data-senderimage="<?= $image;?>" data-foldercolor="<?= $value->folder->folderColors;?>">
		<a href="#">
			<div class="pull-left">
				<img src="<?= $image;?>" class="img-circle" alt="User Image">
			</div>
			<h4>
				<?= $value->sender->fullname;?>
				<small>
<!--					 <i class="fa fa-clock-o"></i> -->
<!--					5 mins-->
				</small>
			</h4>
			<p><?= $value->msg;?></p>
		</a>
	</li>
<? }?>

