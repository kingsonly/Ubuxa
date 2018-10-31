<?php 
	use yii\helpers\Url;
?>
<?php	
    if(!empty($remarks)){
        foreach ($remarks as $key => $remark) {
    
    ?>
           
			<li class="welll">
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="<?= Url::to('@web/images/users/default-user.png'); ?>" alt=""></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name by-author"><a href="http://creaticode.com/blog"><?//= $remark['fullname']; ?></a></h6>
                            <span><?//= $remark['timeElapsedString'];?></span>
                            <i class="fa fa-reply remark-reply" data-id="<?= $remark['remarkId'];?>" id="<?= $remark['remarkId'];?>"></i>
                            <i class="fa fa-heart"></i>
                        </div>
                        <div class="comment-content">
                            <?php  echo $remark['remarkText']; ?>
                        </div>
                    </div>
                </div>

                 <?php foreach($remarkReply as $reply){
                      if($remark['remarkId'] == $reply['parent_id'] ){ 
                 ?>

                <ul class="comments-list reply-list">
                         <li>
                        <!-- Avatar -->
                        <div class="comment-avatar"><img src="<?= Url::to('@web/images/users/default.png'); ?>" alt=""></div>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name"><a href="http://creaticode.com/blog"><?//= $remark['fullname']; ?></a></h6>
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

