<?
use dosamigos\chartjs\ChartJs;
use dosamigos\datepicker\DateRangePicker;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($searchModel, 'date_from')->widget(DateRangePicker::className(), [
	'attributeTo' => 'date_to', 
	'form' => $form, // best for correct client validation
	'language' => 'es',
	'size' => 'lg',
	'clientOptions' => [
		'autoclose' => true,
		'format' => 'yyyy-m-d'
	]
]);?>


<?php ActiveForm::end(); ?>


<?= ChartJs::widget([
    'type' => $type,
    'options' => [
        'height' => 400,
        'width' => 400
    ],
    'data' => [
        'labels' => $label,//["January", "February", "March", "April", "May", "June", "July"],
        'datasets' => [
            [
                'label' => "Customers",
                'backgroundColor' => "rgba(39, 169, 227, 1)",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(39, 169, 227, 1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(39, 169, 227, 1)",
                'data' => $foldersData//[65, 59, 98, 81, 56, 55, 40]
                
            ],
			[
                'label' => "Users",
                'backgroundColor' => "rgba(40, 183, 121, 1)",
                'borderColor' => "rgba(40, 183, 121, 1)",
                'pointBackgroundColor' => "rgba(40, 183, 121, 1))",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(40, 183, 121, 1)",
                'data' => $userData//[65, 59, 98, 81, 56, 55, 40]
            ],
	
			[
                'label' => "Folders",
                'backgroundColor' => "rgba(255, 184, 72, 1)",
                'borderColor' => "rgba(255, 184, 72, 1)",
                'pointBackgroundColor' => "rgba(255, 184, 72, 1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(255, 184, 72, 1)",
                'data' => $foldersData//[65, 59, 98, 81, 56, 55, 40]
                
            ],
			[
                'label' => "Task",
                'backgroundColor' => "rgba(218, 84, 46, 1)",
                'borderColor' => "rgba(218, 84, 46, 1)",
                'pointBackgroundColor' => "rgba(218, 84, 46, 1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(218, 84, 46, 1)",
                'data' => $taskData//[65, 59, 98, 81, 56, 55, 40]
            ],
			
			[
                'label' => "Documents",
                'backgroundColor' => "rgba(34, 85, 164, 1)",
                'borderColor' => "rgba(34, 85, 164, 1)",
                'pointBackgroundColor' => "rgba(34, 85, 164, 1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(34, 85, 164, 1)",
                'data' => $edocumentData//[65, 59, 98, 81, 56, 55, 40]
                
            ],
           
        ]
    ]
]);


?>