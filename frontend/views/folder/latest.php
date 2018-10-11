<?php 

use frontend\models\Folder;
use yii\helpers\Html;

?>
<style>

.folders-container {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	justify-content: space-around;
}

.folder-item, 
.cabinet {
	line-height: 150px;
	font-size: 20px;
	margin: 10px;
	width: 150px;
	text-align: center;	`
}

.folder-item.filled {
	background-image: url('images/folder/folder_full_resized.png');
	background-repeat: no-repeat; 
}

.folder-item.empty {
	background-image: url('images/folder_empty_resized.png');
	background-repeat: no-repeat; 
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


</style>
<section>
	
	<div id="latest-folders" class="folders-container" > 
		
		<?php foreach ($folders as $folder) { ?>
		
			<?php $folderItem = Folder::findOne(['id' => $folder['id']]); //this needs to be optimised/refactored. $folderItem is only used to get the value of isEmpty! ?>
			<div id="folder-item-<?php echo $folder['id']; ?>" class="folder-item <?php echo $folderItem->isEmpty ? 'empty' : 'filled' ?>"> 
				<span class="folder-ref">
					<?php 
					echo $folder['title']; 
					echo Html::a(Html::tag( 'span', Html::tag('i', '', ['class' => 'folder-tag', 'title' => 'Open folder']) ),['folder/view', 'id' => $folder['id']] );
					?>
					<section>
					<?
					$numItems = count($folder->tree);
					$i = 0;
					foreach($folder->tree as $path){ 
					if(++$i === $numItems) {
						?>
						<span> <?= $path->title; ?> </span>
					<?  }else{ ?>
						<span> <?= $path->title; ?> ></span>
					<? }; }; ?>
					</section>
				</span>
			</div>
		<?php } ?>
		<div id="cabinet" class="cabinet"> 
			<span class="cabinet-span">
				<?php 
				echo Yii::t('common', 'open_cabinet') ; 
				echo Html::a(Html::tag( 'span', Html::tag('i', '', ['class' => 'folder-tag', 'title' => 'Open Cabinet']) ),['folder/index'] );
				?>
			</span>
		</div>

	</div>
</section>