<?php 
	use yii\helpers\Url;
?>
<?php	

    if(!empty($remarks)){
        foreach ($remarks as $key => $remark) {
        $image = !empty($remark["userImage"]) ? $remark["userImage"] : 'images/users/default-user.png';
    
    ?>
           
			<li class="welll welll_<?= $remark['id'];?>">
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <div class="comment-avatar" style="background-image: url('<?= Url::to($image); ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name by-author"><a href="#"><?= $remark['fullname']; ?></a></h6>
                            <span><?= $remark['timeElapsedString'];?></span>
                            <a href="#" data-toggle="tooltip-reply" title="reply message"><i class="fa fa-reply remark-reply" data-id="<?= $remark['id'];?>" id="<?//= $remark['id'];?>"></i></a>
                        </div>
                        <div class="comment-content">
                            <?php  echo $remark['text']; ?>
                        </div>
                    </div>
                </div>

                 <?php foreach($remarkReply as $reply){
                      if($remark['id'] == $reply['parent_id'] ){ 
                      $imageReply = !empty($reply["userImage"]) ? $reply["userImage"] : 'images/users/default-user.png';
                 ?>

                <ul class="comments-list reply-list">
                         <li>
                        <!-- Avatar -->
                        <div class="comment-avatar" style="background-image: url('<?= Url::to($imageReply); ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name"><a href="#"><?= $reply['fullname']; ?></a></h6>
                                <span><?//= $reply['timeElapsedString'];?></span>
                            </div>
                            <div class="comment-content">
                                <?= $reply['text'];?>
                            </div>
                        </div>
                    </li>
                </ul>
                <?php } }?>
            </li>
            
       
<?php } }?>

