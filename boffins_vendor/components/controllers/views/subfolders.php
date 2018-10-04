<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<style type="text/css">
	.subfolder-container{
		padding-left: 15px;
	    background: #fff;
	    padding-right: 15px;
	    box-shadow: 4px 19px 25px -2px rgba(0,0,0,0.1);
	}
	.box-sub-folders {
		height:122px;
	}

	.box-subfolders {
		height:122px;
	}

	.subheader {
	    padding-top: 7px;
	    padding-bottom: 7px;
	    font-weight: bold;
	    background-color: #fff;
	    border-bottom: 1px solid #ccc;
	}
	.sub-second {
		padding-right: 0px !important;
    	padding-left: 0px !important;
	}
	.subfirst {
		background-color: transparent;
    padding-left: 0px !important;
    padding-right: 0px !important;
    background: #fff;
	}
	.info-2 {
		background-color: #fff;
	}
</style>
<div class="col-md-7">
	<div class="col-sm-12 col-xs-12 subfolder-container column-margin">
		<div class="subheader">SUB FOLDERS</div>
		<div class="col-xs-5 col-sm-2 sub-second">
				<div class="info-2">
					<div class="box-subfolders">Hello</div>
				</div>
   		</div>
		<div class="col-xs-7 col-sm-10 subfirst ">
			<div class="info-2">
				<div class="box-sub-folders">Hello World!</div>
			</div>
		</div>
	</div>
</div>