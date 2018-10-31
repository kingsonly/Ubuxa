<style>
  
.under_list {
  list-style-type: none;
}


 .accordion {
  width: 100%;
  max-width: 360px;
  margin: 30px auto 20px;
  background: #FFF;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
 }

.accordion .link {
  cursor: pointer;
  display: block;
  padding: 15px 15px 15px 42px;
  color: #4D4D4D;
  font-size: 14px;
  font-weight: 700;
  border-bottom: 1px solid #CCC;
  position: relative;
  -webkit-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
}

.accordion li:last-child .link {
  border-bottom: 0;
}

.accordion .first-list i {
  position: absolute;
  top: 16px;
  left: 12px;
  font-size: 18px;
  color: #595959;
  -webkit-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
}

.accordion .first-list i.fa-chevron-down {
  right: 12px;
  left: auto;
  font-size: 16px;
}

.accordion .first-list .open .link {
  color: #b63b4d;
}

.accordion .first-list .open i {
  color: #b63b4d;
}
.accordion .first-list .open i.fa-chevron-down {
  -webkit-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  -o-transform: rotate(180deg);
  transform: rotate(180deg);
}

.accordion .first-list .default .submenu {display: block;}
/**
 * Submenu
 -----------------------------*/
 .submenu {
  display: none;
  background: #444359;
  font-size: 14px;
 }

 .submenu first-list {
  border-bottom: 1px solid #4b4a5e;
 }

 .submenu a {
  display: block;
  text-decoration: none;
  color: #d9d9d9;
  padding: 12px;
  padding-left: 42px;
  -webkit-transition: all 0.25s ease;
  -o-transition: all 0.25s ease;
  transition: all 0.25s ease;
 }

.accord:hover {
  background: #b63b4d;
  color: #FFF;
 }
</style>

  <ul id="accordion" class="accordion under_list">
    <li class="first-list">
      <div class="link"><i class="fa fa-paint-brush iconz"></i>Diseño web<i class="fa fa-chevron-down"></i></div>
      <ul class="submenu under_list">
        <li class="second-list"><a href="#" class="accord">Photoshop</a></li>
      </ul>
    </li>
    <li class="first-list">
      <div class="link"><i class="fa fa-code iconz"></i>Desarrollo front-end<i class="fa fa-chevron-down"></i></div>
      <ul class="submenu under_list">
        <li class="second-list"><a href="#" class="accord">Javascript</a></li>
      </ul>
    </li>
    <li class="first-list">
      <div class="link"><i class="fa fa-mobile iconz"></i>Diseño responsive<i class="fa fa-chevron-down"></i></div>
      <ul class="submenu under_list">
        <li class="second-list"><a href="#" class="accord">Tablets</a></li>
      </ul>
    </li>
    <li class="first-list"><div class="link"><i class="fa fa-globe iconz"></i>Posicionamiento web<i class="fa fa-chevron-down"></i></div>
      <ul class="submenu under_list">
        <li class="second-list"><a href="#" class="accord">Google</a></li>
      </ul>
    </li>
  </ul>

<?php
$accordion = <<<JS
  $(function() {
  var Accordion = function(el, multiple) {
    this.el = el || {};
    this.multiple = multiple || false;

    // Variables privadas
    var links = this.el.find('.link');
    // Evento
    links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
  }

  Accordion.prototype.dropdown = function(e) {
    var \$el = e.data.el;
      \$this = $(this),
      \$next = \$this.next();

    \$next.slideToggle();
    \$this.parent().toggleClass('open');

    if (!e.data.multiple) {
      \$el.find('.submenu').not(\$next).slideUp().parent().removeClass('open');
    };
  } 

  var accordion = new Accordion($('#accordion'), false);
});
JS;
$this->registerJs($accordion);
?>