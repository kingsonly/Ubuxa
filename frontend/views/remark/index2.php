<?php 
        foreach ($remarks as $key => $remark) {
    ?>
           
			<li class="welll">
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name by-author"><a href="http://creaticode.com/blog"><?php  echo $remark['fullname']; ?></a></h6>
                            <span><?= $remark['timeElapsedString'];?></span>
                            <i class="fa fa-reply"></i>
                            <i class="fa fa-heart"></i>
                        </div>
                        <div class="comment-content">
                            <?php  echo $remark['text']; ?>
                        </div>
                    </div>
                </div>
            </li>
            
       
<?php } ?>

