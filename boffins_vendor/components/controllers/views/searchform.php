<style>
#wrap {
  margin: 10px 10px;
  display: inline-block;
  position: relative;
  height: 30px;
  padding: 0;
  position: relative;
	width: 100%;
}
	#search-form{
		width: inherit;
	}

#search {
  height: 30px;
  font-size: 1.5rem;
  display: inline-block;
  font-weight: 100;
  border: none;
  outline: none;
  color: #000;
  padding: 3px;
  padding-right: 60px;
  width: 0px;
  position: absolute;
  top: 0;
  right: 0;
  background: none;
  z-index: 3;
  transition: width .4s cubic-bezier(0.000, 0.795, 0.000, 1.000);
  cursor: pointer;
}

#search:focus:hover {
  border-bottom: 1px solid #BBB;
}

#search:focus {
  width: inherit;
  z-index: 1;
  border-bottom: 1px solid #BBB;
  cursor: text;
}
input[type="button"] {
  height: 22px;
  width: 63px;
  display: inline-block;
  color:red;
  background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAMAAABg3Am1AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAADNQTFRFU1NT9fX1lJSUXl5e1dXVfn5+c3Nz6urqv7+/tLS0iYmJqampn5+fysrK39/faWlp////Vi4ZywAAABF0Uk5T/////////////////////wAlrZliAAABLklEQVR42rSWWRbDIAhFHeOUtN3/ags1zaA4cHrKZ8JFRHwoXkwTvwGP1Qo0bYObAPwiLmbNAHBWFBZlD9j0JxflDViIObNHG/Do8PRHTJk0TezAhv7qloK0JJEBh+F8+U/hopIELOWfiZUCDOZD1RADOQKA75oq4cvVkcT+OdHnqqpQCITWAjnWVgGQUWz12lJuGwGoaWgBKzRVBcCypgUkOAoWgBX/L0CmxN40u6xwcIJ1cOzWYDffp3axsQOyvdkXiH9FKRFwPRHYZUaXMgPLeiW7QhbDRciyLXJaKheCuLbiVoqx1DVRyH26yb0hsuoOFEPsoz+BVE0MRlZNjGZcRQyHYkmMp2hBTIzdkzCTc/pLqOnBrk7/yZdAOq/q5NPBH1f7x7fGP4C3AAMAQrhzX9zhcGsAAAAASUVORK5CYII=) center center no-repeat;
  text-indent: -10000px;
  border: none;
  position: absolute;
  top: 0;
  right: 0;
  z-index: 2;
  cursor: pointer;
  opacity: 0.4;
  cursor: pointer;
  transition: opacity .4s ease;
	background-size:contain;
}

#search:hover {
  opacity: 0.8;
}
</style>
<div id="wrap">
  <form action="" autocomplete="on" id="search-form">
  <input id="search" name="search" type="text" placeholder="Search for folders"><input id="search_submit" value="Search" type="button">
  </form>
</div>

<?
$Search = <<<Search
  $("#search").on("click", function() {
    options = {
		  "closeButton": true,
		  "debug": false,
		  "newestOnTop": true,
		  "progressBar": true,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": true,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "0",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		  "hideMethod": "fadeOut",
		  "tapToDismiss": false
		  }
		toastr.info("You can View all subfolder from the side bar", "Title", options);
  });		
Search;
 
$this->registerJs($Search);
?>