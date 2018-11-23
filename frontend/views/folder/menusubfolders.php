
	<?php foreach ($subfolders as $folders) { ?>
		<li class="has-children has-other">
	        <input type="checkbox" name ="sub-group-1">
	    <label class="accord-label menu-check padding-checker" for="sub-group-1" id="menu-folders<?=$folders->id ?>" data-menuId="<?=$folders->id;?>"><i class="fa fa-folder iconz"></i><?= $folders->title ?>
	    <?php if(!empty($folders->subFolders)){ ?>
	    	<i class="fa fa-chevron-down iconz-down"></i>
	    <?php }?>
	    	<input type="hidden" value="false" name="">
	    </label>

	    </li>
	<?php }?>


