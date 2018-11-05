
<style>
.overlay {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0, 0.9);
    overflow-x: hidden;
    transition: 0.5s;
}

.overlay-content {
    position: relative;
    top: 25%;
    width: 100%;
    text-align: center;
    margin-top: 30px;
}

.overlay a {
    padding: 8px;
    text-decoration: none;
    font-size: 36px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.overlay a:hover, .overlay a:focus {
    color: #f1f1f1;
}

.overlay .closebtn1 {
    position: absolute;
    top: 20px;
    right: 45px;
    font-size: 60px;
}

@media screen and (max-height: 450px) {
  .overlay a {font-size: 20px}
  .overlay .closebtn {
    font-size: 40px;
    top: 15px;
    right: 35px;
  }
}
</style>


<div id="myOverlay" class="overlay">
  <a href="javascript:void(0)" class="closebtn1" onclick="closeOverlay()">&times;</a>
  <div class="overlay-content">
    
  </div>
</div>

<span style="font-size:30px;cursor:pointer" onclick="openOverlay()">&#9776; open</span>

<?php 
$taskView = Url::to(['task/view','id' => $taskids,'folderId' => $id]);
$overlay = <<<JS
    function openOverlay() {
        $('#content').load( '$taskView' );
      document.getElementById("myOverlay").style.width = "50%";
    }

    function closeOverlay() {
      document.getElementById("myOverlay").style.width = "0%";
    }

    
JS;
$this->registerJs($overlay, $this::POS_END);
?>     

