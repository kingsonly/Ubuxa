<?php
use yii\widgets\DetailView;
use boffins_vendor\components\controllers\DisplayLinkedComponents;
/* @var $this yii\web\View */
/* @var $model app\models\Payment */
?>
<style>
#invoicecontent{
	background: #fff;
	margin-top: 20px;
	min-height: 600px;
}
</style>
<div class="sponsor" title="Click to flip">
	<div class="sponsorFlip" style="background:red !important">
		<div class="">
			<div class="box" id="invoicecontent">
				<div class="box-body">

					<? if($modelClassName == 'Payment'){ ?>
						<h3>
							Payment from <?=$model->payment_source_id != 'no data to return'?$model->sourceCode:'<em style="color:red">(Source not specified)</em>'; echo " to ".$model->receiver;?>
						</h3>
					<? } else{ ?>
						<h3><?= $modelClassName; ?> - <?= $model->$title;?></h3>
					<? } ?>

					<?= DetailView::widget([
					'model' => $model,
					'attributes' => $viewAttributes,
					]); ?>

					
				</div>
			</div>
		</div> 


		<script>
		$('.edocumentfolder').bind("click",function(){

			// $(this) point to the clicked .sponsorFlip element (caching it in elem for speed):

			var elem = $(this);

			// data('flipped') is a flag we set when we flip the element:

			if(elem.data('flipped'))
			{
			// If the element has already been flipped, use the revertFlip method
			// defined by the plug-in to revert to the default state automatically:


			}
			else
			{
			// Using the flip method defined by the plugin:

				$('.sponsorFlip').flip({
					direction:'lr',
					speed: 350,
					onBefore: function(){
					// Insert the contents of the .sponsorData div (hidden from view with display:none)
					// into the clicked .sponsorFlip div before the flipping animation starts:

						$('.sponsorFlip').load(elem.data('url'));
					}
				});

				// Setting the flag:
				$('.sponsorFlip').data('flipped',true);
				$('.sponsorFlip').css('background-color','red !important')
			}
		});

		</script>
	</div>


</div>

