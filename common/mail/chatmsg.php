<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>

<tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="480" >
              <!-- COPY -->
				<tr >
				<td colspan="3" bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"> Dear <?= $customerName;?> you have <?= count($msgArray);?> messages.
					</td>
				</tr>
				
				<? $i=1; foreach($msgArray as $key => $value){?>
				
              <tr>
                
				  <td  bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                 <?= $i;?>
                </td>
				  
				<td colspan="2" bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                 <?= $value['fullname'];?> sent <?= $value['msg'];?> in <?= $value['foldertitle'];?> folder
                </td>
				  
              </tr>
             <? $i++; }?>
             
            </table>
        </td>
    </tr>
   