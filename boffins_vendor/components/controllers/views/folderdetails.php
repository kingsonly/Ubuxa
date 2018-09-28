<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<style type="text/css">
	.info{
		background: #fff;
	    padding-left: 15px;
	    box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
	    border-bottom: 5px solid rgb(7, 71, 166);
	}

	.folder-header {
	    padding-top: 7px;
	    padding-bottom: 7px;
	    font-weight: bold;
	}

	.box-content-folder {
		border-top: 1px solid #ccc;
		height:120px;
	}

	.folder-side {
		
	}
	.box-folders {
		padding-left: 0px;
    	padding-right: 0px;
	}
</style>

<div class="col-md-5 folderdetls">
	<div class="col-sm-12 col-xs-12 info column-margin">
		<div class="folder-header">FOLDER DETAILS</div>
		<div class="col-sm-7 col-xs-7 box-folders">
			<div class="folder-side">
				<div class="box-content-folder">Hello World!</div>
			</div>
		</div>
		<div class="col-sm-5 col-xs-5 box-folders-count">
            <div class="active-client-number">Test</div>
        </div>
	</div>
</div>
