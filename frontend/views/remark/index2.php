<?php 
	use yii\helpers\Url;
?>
<?php	

    if(!empty($remarks)){
        foreach ($remarks as $key => $remark) {
        $image = !empty($remark["userImage"]) ? $remark["userImage"] : 'default-user.png';
    
    ?>
           
			<li class="welll">
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="<?= Url::to('@web/images/users/' . $image); ?>" alt=""></div>
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
                      $imageReply = !empty($reply["userImage"]) ? $reply["userImage"] : 'default-user.png';
                 ?>

                <ul class="comments-list reply-list">
                         <li>
                        <!-- Avatar -->
                        <div class="comment-avatar"><img src="<?= Url::to('@web/images/users/' . $imageReply ); ?>" alt=""></div>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name"><a href="http://creaticode.com/blog"><?= $reply['fullname']; ?></a></h6>
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

