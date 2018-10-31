<?php

use yii\helpers\Html;
use yii\grid\GridView;
use boffins_vendor\components\controllers\FolderCreateWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Folders';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.private{
	background-color: red;
}
.author{
	background-color: blue;
}
.users{
	background-color: aquamarine;
}
.folders-container {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	justify-content: space-around;
}

.folder-item{
	line-height: 150px;
	font-size: 20px;
	width:70px;
	text-align: center;
	display: inline-block;
	
}	

.folder-item.filled {
	background-image: url('images/folder/folderfill.png');
	background-repeat: no-repeat; 
	background-size: cover; 
	height: 60px;
}

.folder-item.empty {
	background-image: url('images/folder/folderempty.png');
	background-repeat: no-repeat; 
	background-size: cover; 
	height: 60px;
}
	
	.folder-create{
	background-image: url('images/folder/folderempty.png');
	background-repeat: no-repeat; 
	background-size: cover; 
	height: 60px;
	display: inline-block;
	width: 69px;
}

.cabinet {
	background-image: url('images/cabinet_resized.png');
	background-repeat: no-repeat; 
}

.folder-ref,
.cabinet-span {
	width: 100%;
	height: 100%;
	display: block;
	position: relative;
}

.folder-ref a,
.cabinet-span a {
	width: 100%;
	height: 100%;
	display: block;
	position:absolute;
	left: 0;
	top: 0;
	text-decoration: none; /* No underlines on the link */
	z-index: 10; /* Places the link above everything else in the div */
	background-color: #FFF; /* Fix to make div clickable in IE */
	opacity: 0; /* Fix to make div clickable in IE */
	filter: alpha(opacity=1); /* Fix to make div clickable in IE */
}

@media screen and (min-width: 320px) and (max-width: 599px) {
	/*************BASIC MOBILE PHONE(320px AN ABOVE) TO TABLET VIEW (600px ABD ABOVE) ***************/
	.folder-item {
		order: 2;
	}
	.cabinet {
		order: 1;
	}
}

.owl-buttons {
  display: none;
}


.owl-item {
  text-align: center;
}

	
	.owl-prev {
    width: 15px;
    height: 57px;
    position: absolute;
    top: 0%;
    margin-left: -20px;
    display: block!IMPORTANT;
    border:0px solid black;
}

.owl-next {
    width: 15px;
    height: 57px;
    position: absolute;
    top: 0%;
    right: 8px;
    display: block!IMPORTANT;
    border:0px solid black;
}
.owl-prev i, .owl-next i { 
	color: #ccc !important; 
	font-size:20px
}
.owl-prev:hover,.owl-next:hover{
	background-color: rgba(255, 0, 0, 0) !important ;
}
 .owl-carousel .owl-nav button.owl-prev{
	border-right: solid #ccc 1px !important;
	padding-right: 18px !IMPORTANT;
	 left: -10px;
	 border-radius:0px !important;
	 background: #fff !important;
}
 .owl-carousel .owl-nav button.owl-next{
	border-left: solid #ccc 1px !important;
	padding-left: 5px !IMPORTANT;
	 border-radius:0px !important;
	 background: #fff !important;
}

.folder-content{
	padding-right: 0px;
}

.folder-text{
	padding-left: 0px;
	padding-right: 0px;
	text-align: left;
	padding-bottom: 25px;
	color: #333;
	overflow: hidden;	
	width:40%;
	white-space: nowrap;
	display: inline-block;
}

.ellipsis
{
text-overflow: ellipsis;
}

.create-new-folder{
	display:none;
}
#carousles{
	margin-top: 10px;
}
.owl-prev{
	width:23px !important;
} 
</style>

<div class="folder-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= FolderCreateWidget::widget(); ?>
    </p>
	<div class="row" style="background:#fff;">
		<? 
		$categoryToTag1 = array();
		foreach ($dataProvider as $folderOneFilter) {
			
			if($folderOneFilter->parent_id == '0'){
				if($folderOneFilter->folderManagerFilter->role == 'author'){
				$categoryToTag1['mainfolder'][$folderOneFilter->private_folder][] = $folderOneFilter;
			}else{
				$categoryToTag1['mainfolder']['shared'][] = $folderOneFilter;
			}
			} else{
				if($folderOneFilter->folderManagerFilter->role == 'author'){
				$categoryToTag1['subfolder'][$folderOneFilter->private_folder][] = $folderOneFilter;
			}else{
				$categoryToTag1['subfolder']['shared'][] = $folderOneFilter;
			}
			}
			

		}
		
		foreach($categoryToTag1 as $key => $folder){?>
		
			<div style="border:solid 2px red; margin-top:20px;">
				<?= $key;?>
			<? foreach($folder as $actuallFolder){?>
			
			<? foreach($actuallFolder as $newactualfolder){?>
		
			
				<?= $newactualfolder->id;?>
			
			<? }?>
		
			<? }?> 
			</div>
		<? }?> 
	
	</div>
	


	
</div>

<pre>
		<? //var_dump($categoryToTag1);?>
	</pre>	

<!--
<?/*
			 $url = Url::to(['folder/view', 'id' => $folder['id']]);
			 ?>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6" style="padding: 20px;">
            <a href="<?= $url;?>" data-pjax="0">
			 	<div id="folder-item-<?php echo $folder['id']; ?>" class="folder-item <?php echo $folder->isEmpty ? 'empty' : 'filled' ?> <?= $folder->folderColors; ?>" data-toggle="tooltip" title="<?= $folder['title']; ?>" data-placement="bottom"> 
				</div>
			 	<div class="folder-text .ellipsis">
					
						<?= $folder['title'];*/ ?>
					
				</div>
				</a>
        </div>
-->