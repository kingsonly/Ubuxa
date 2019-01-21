<?php
foreach ($taskGroup->taskTitle as $key => $value) {
?>
<li><?= strip_tags($value['title']);?></li>
<?php 
}
?>
