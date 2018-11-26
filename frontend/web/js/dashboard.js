/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/
$(window).on('load', function () {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});

function dueDateCountDown(id,datess)
{	
	try{
		var countDownDate = new Date(datess).getTime();
		
		var x = setInterval(function() {
			// Check if element id is null
			if(document.getElementById(id) == null){
				clearInterval(x);
			}
			
			// Get todays date and time
			var now = new Date().getTime();

			// Find the distance between now an the count down date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			// Output the result in an element with id="demo"
			
			
			if(typeof id !== 'undefined' && id !== null) {
				document.getElementById(id).innerHTML = "(Time remaining): "+days + "d " + hours + "h "
				+ minutes + "m " + seconds + "s ";

			} 

			// If the count down is over, write some text 
			if (distance < 0) {
				clearInterval(x);
				document.getElementById(id).innerHTML = "EXPIRED";
			}
		}, 1000);
		
	
	}catch(er){
		
	}
	
}
 
/*$(".box-black").hover(function(){
	//alert(12);
	var parent =$(this).parent();
	var buttonClassName =$(this).data('values');
	
	$(this).find('.newremark').css('opacity', 0);
	$(this).find('.newremark').show();
	
    $(this).find('.newremark').animate({opacity: 1}, {queue: false, duration: 10});
$(this).find('.newremark').animate({ top: "-10px" }, 10);
},
function(){
   // $("#homeText").fadeOut();
	var parent =$('this').parent();
	var buttonClassName =$(this).data('value');
	
	$(this).find('.newremark').css('opacity', 0.5);
	
	
    $(this).find('.newremark').animate({opacity: 0.2}, {queue: false, duration: 'slow'});
$(this).find('.newremark').animate({ top: "-10px" }, 'slow');
	$(this).find('.newremark').slideUp('3000');
	
});*/

$(document).ready(function(){
	
	
	$(document).on('change','#componentlist',function(){
	var components = $("#components option:selected").text().toLowerCase();
	var componentsId = $(this).val();
	var componentsIdText = $("#componentlist option:selected").text();
	
	if(Boolean($(document).find('#itemType').val())){
		var componentType = $(document).find('#itemType').val().split(',');
		componentType.push(components);
		
		
	} else {
		componentType = components;
	}
	
	if(Boolean($(document).find('#itemType').val())){
		var componentId =$(document).find('#itemID').val().split(',');
		componentId.push(componentsId);
		
		
	} else {
		componentId = componentsId;
	}
	
	
	if(componentType instanceof Array){
		componentTypeString = componentType.toString().split(',');
		componentIdString = componentId.toString().split(',');
		var description = $(document).find('.description').text().split(",");
		description.push(componentsIdText);
		$(document).find(".description").html('');
		$(document).find('.description').append(description.toString());
		
		$(document).find(".linkedcomponentlistt").html('');
		$(document).find(".counnter").html(componentTypeString.length);
		for (var i = 0; i < componentTypeString.length; ++i) {
			
		
		$(document).find(".linkedcomponentlistt").append("<div class='linkedcomponentlist'><span class='caption'>"+componentTypeString[i].toString()+' '+description[i].toString()+"</span><div id = 'trash'>"+' <i class="hvr-bounce-in fa fa-trash deleted" data-index="'+i+'"></i>'+"</div></div>");	
		
		}
		
	}else{
		componentTypeString = componentType.toString();
		componentIdString = componentId.toString();
		description = componentsIdText.toString();
		$(document).find(".description").html('');
		$(document).find('.description').append(description);
		
		$(document).find(".linkedcomponentlistt").html('');
		$(document).find(".counnter").html('1');
		$(document).find(".linkedcomponentlistt").append("<div class='linkedcomponentlist'><span class='caption'>"+componentTypeString+' '+description+"</span><div id = 'trash'>"+' <i class="hvr-bounce-in fa fa-trash deleted" data-index="0"></i>'+"</div></div>");
		
	}
	
	
	
	$(document).find('#itemID').val(componentId.toString());
	$(document).find('#itemType').val(componentType.toString());
	//$(document).find('.description').val(componentIdString.toString());
})

// Delete a linked product 
	$(document).on('click','.deleted',function()
	{
		var dataIndexValue = $(this).data('index');
		var componentTypeFormField = $(document).find('#itemType').val().split(',');
		var componentIdFormField = $(document).find('#itemID').val().split(',');
		var componentDescription = $(document).find('.description').text().split(',');

	//console.log(componentTypeFormField);
		// slice the index 
		componentTypeFormField.splice(dataIndexValue,1) ;
		componentIdFormField.splice(dataIndexValue,1) ;
		componentDescription.splice(dataIndexValue,1);

		// append back to the respective html element 

		$(document).find('#itemType').val(componentTypeFormField.toString());
		$(document).find('#itemID').val(componentIdFormField.toString());
		$(document).find('.description').html(componentDescription.toString());


		$(document).find(".linkedcomponentlistt").html('');//clear previous content first 
		$(document).find(".counnter").html(componentTypeFormField.length);
		for (var i = 0; i < componentTypeFormField.length; ++i) {
			
			$(document).find(".linkedcomponentlistt").append("<div class='linkedcomponentlist'><span class='caption'>"+componentTypeFormField[i].toString()+' '+componentDescription[i].toString()+"</span><div id = 'trash'>"+' <i class="hvr-bounce-in fa fa-trash deleted" data-index="'+i+'"></i>'+"</div></div>");	

			}

	})
	
	
	$(document).on('click','.showlinked',function(){
		$(document).find(".linkedcomponentlistt").fadeToggle();
	})

	$(document).on('click','.modal-dialog form div:gt(5)',function(){
		$(document).find(".linkedcomponentlistt").hide();

	})


// show and hide linkes 


	$("#projectviewcontainer").stick_in_parent().on("sticky_kit:stick", function(e) {
    	console.log("has stuck!", e.target);
	})
  .on("sticky_kit:unstick", function(e) {
    	console.log("has unstuck!", e.target);
  });


	$.ajaxSetup ({
    // Disable caching of AJAX responses
    	cache: false
	});
		
	
	
	$('.modal').on('hidden.bs.modal', function (e) {
		if($('.modal').hasClass('in')) {
			$('body').addClass('modal-open');
		}else{
			
		}  
	});
	
	
	$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
		options.async = false;
	});
	

	$(document).on('click','.newClients',function(){
		var dataUrl = $(this).data('url');
		$('#clientsupplier').modal('show').find('#contentclientnsuppliers').load(dataUrl);
		

	});
	
	$(document).on('click','.newSuppliers',function(){
		var dataUrl = $(this).data('url');
		$('#clientsupplier').modal('show').find('#contentclientnsuppliers').load(dataUrl);
		

	});

	$(".box-black").hover(function(){
	  //alert(12);
	  	var parent =$(this).parent();
	  	var buttonClassName =$(this).data('values');

	  	$(this).find('.his').css('opacity', 0.5);
		$(this).find('.his').show();

		$(this).find('.his').animate({opacity: 1}, {queue: false, duration: 'slow'});
		$(this).find('.his').animate({ top: "-10px" }, 'slow');
	 //$(this).find('.his').slideDown('3000');
	},
						  
function(){
   // $("#homeText").fadeOut();
  var parent =$('this').parent();
  var buttonClassName =$(this).data('value');
  
  $(this).find('.his').css('opacity', 0.5);
  
  
    $(this).find('.his').animate({opacity: 0.2}, {queue: false, duration: 'slow'});
$(this).find('.his').animate({ top: "-10px" }, 'slow');
  $(this).find('.his').slideUp('3000');
  
});

 
$('#newfolder').click(function(){
	
	var datas=$(this).data('values');
	$('.hideall').hide();
	$('#formcontent').show();
	$('#dashboard').modal('show').find('#formcontent').html('<img class="loadergif" src="images/loader.gif"  />');
  $('#dashboard').modal('show').find('#formcontent').load(datas);
  $('#dashboard').modal('show').find('#headers').html(' ');
	$('#dashboard').modal('show').find('#headers').html('Create New Folder');
});

$('#projectmodal2').click(function(){

$('body').removeClass('modal-open');
$('.modal-backdrop').remove();
	
});

$(document).on('click','#caret', function(){

	finder = $(this).find('.fa')

		if(finder.hasClass('fa-caret-up')){
			//alert(1);
			var parent = $(this).parent();
			var getActiveText = $('#contactsContainer').find('li.active a').text();
			
			$(document).find('#sliderwiz').hide();
			$(document).find('#sliderwizz p').html(getActiveText);
			$(document).find('#sliderwizz').show();
			
			$(document).find('#sliderwizz3').hide();
			$(document).find('#sliderwizz2').hide();
			$(document).find('#sliderwizz1').hide();

			
		} else {
			
				
				$(document).find('#sliderwiz').show();
				$(document).find('#sliderwizz').hide();
				$(document).find('#sliderwizz3').hide();
				$(document).find('#sliderwizz2').hide();
				$(document).find('#sliderwizz1').hide();
			
		}
	})



$('#newproject').click(function(){
	
	var datas=$(this).data('values');
	$('.hideall').hide();
	$('#formcontent').show();
	$('#dashboard').modal('show').find('#formcontent').html('<img class="loadergif" src="images/loader.gif"  />');
	$('#dashboard').modal('show').find('#formcontent').load(datas);
  $('#dashboard').modal('show').find('#headers').html(' ');
  $('#dashboard').modal('show').find('#headers').html('Create New Project');
});


$('#newinvoice').click(function(){
	
	var datas=$(this).data('values');
	$('.hideall').hide();
	$('#formcontent').show();
	$('#dashboard').modal('show').find('#formcontent').html(' <img class="loadergif" src="images/loader.gif"  />');
	$('#dashboard').modal('show').find('#formcontent').load(datas);
  $('#dashboard').modal('show').find('#headers').html(' ');
  $('#dashboard').modal('show').find('#headers').html('Create New Invoice');
});

// jquery for update and delete 

$(document).on('click','.update',function(){
	
	var datas=$(this).data('url');
	$('.hideall').hide();
	$('#formcontent').show();
	$('#dashboard').modal('show').find('#formcontent').html('<img class="loadergif" src="images/loader.gif"  />');
	$('#dashboard').modal('show').find('#formcontent').load(datas);
  $('#dashboard').modal('show').find('#headers').html(' ');
  //$('#dashboard').modal('show').find('#headers').html('Update Contact');
});


$(document).on('click','.delete',function(){
	var url = $(this).data('url');
	if(confirm('Are you sure?')) {
    $.post(url, function(data, status){
        alert('sent');
    });
  }
    
});


$('#neworder').click(function(){
	
	var datas=$(this).data('values');
	$('.hideall').hide();
	$('#formcontent').show();
	$('#dashboard').modal('show').find('#formcontent').html(' <img class="loadergif" src="images/loader.gif"  />');
	$('#dashboard').modal('show').find('#formcontent').load(datas);
  $('#dashboard').modal('show').find('#headers').html(' ');
  $('#dashboard').modal('show').find('#headers').html('Create New Order');
});




$(function(){
    $('#modelbutton').click(function(){
        $('#modall').modal('show')
            //.find('#modelContent')
            //.load($(this).attr('value'));
    });
})

// dashboard click event for new client / supplier /user / remarks and person
$(document).on('click','#newclient',function(){
	$('.hideall').hide();
	$('#clientcontent').show();
	$('#dashboard').modal('show');
});


$(document).on('click','#newremark',function(){
	$('.hideall').hide();
	$('#remarkcontent').show();
	$('#dashboard').modal('show');
});


$(document).on('click','#newsupplier',function(){
	$('.hideall').hide();
	$('#suppliercontent').show();
	$('#dashboard').modal('show');
});

$(document).on('click','#newuser',function(){
	$('.hideall').hide();
	$('#usercontent').show();
	$('#dashboard').modal('show');
});

$(document).on('click','#newperson',function(){
	$('.hideall').hide();
	$('#personcontent').show();
	$('#dashboard').modal('show');
});


$('#projectclick').click(function(){
	
	var datas=$(this).data('values');
	var tyc_ref=$(this).data('tyc_ref');
	$('#headers').html('Project');
	$('#projectmodal2').modal('show').find('#modalcontent2').html('<img class="loadergif" src="images/loader.gif"  /> ');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas,{option:tyc_ref});
});

$('#invoiceclick').click(function(){
	
	var datas=$(this).data('values');
	var tyc_ref=$(this).data('tyc_ref');
	//$('#headers').html('Project');
	$('#projectmodal2').modal('show').find('#modalcontent2').html('<img class="loadergif" src="images/loader.gif"  />');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas,{option:tyc_ref});
});

$('#orderclick').click(function(){
	
	var datas=$(this).data('values');
	var tyc_ref=$(this).data('tyc_ref');
	//$('#headers').html('Project');
	$('#projectmodal2').modal('show').find('#modalcontent2').html('<img class="loadergif" src="images/loader.gif"  /> ');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas,{option:tyc_ref});
});


$('#paymentsourceclick').click(function(){
	
	var datas=$(this).data('values');
	$('#headers').html('Payment Source');
	$('#projectmodal').modal('show').find('#modalcontent').html(' <img class="loadergif" src="images/loader.gif"  />');
	$('#projectmodal').modal('show').find('#modalcontent').load(datas);
});

$('#rpoclick').click(function(){
	
	var datas=$(this).data('values');
	var tyc_ref=$(this).data('tyc_ref');
	$('#headers').html('Project');
	$('#projectmodal2').modal('show').find('#modalcontent2').html('<img class="loadergif" src="images/loader.gif"  /> ');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas,{option:tyc_ref});
});

$('#taskreminderclick').click(function(){
	
	$('#taskremindermodal').modal('show');
	//$('#projectmodal').modal('show').find('#modalcontent1').load(datas).show();
});


$('#payment_paymentsource_click').click(function(){
	
	$('#pay_and_sourcemodal').modal('show');
	
});


$('#taskclick').click(function(){
	var datas=$(this).data('values');
	$('#taskreminderheaders').html('Task');
	$('#projectmodal2').modal('show').find('#modalcontent2').html('<img class="loadergif" src="images/loader.gif"  /><img class="loadergif" src="images/loader.gif"  /> ');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas);
});

$('#reminderclick').click(function(){
	
	var datas=$(this).data('values');
	$('#taskreminderheaders').html('Reminder');
	$('#projectmodal2').modal('show').find('#modalcontent2').html('<img class="loadergif" src="images/loader.gif"  /> ');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas);
});


$('#remarksclick').click(function(){
	
	var datas=$(this).data('values');
	$('#headers').html('Project');
	$('#projectmodal2').modal('show').find('#modalcontent2').html('<img class="loadergif" src="images/loader.gif"  /> ');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas);
});


$('#correspondenceclick').click(function(){
	
	var datas=$(this).data('values');
	var tyc_ref=$(this).data('tyc_ref');
	$('#headers').html('Correspondence');
	$('#projectmodal2').modal('show').find('#modalcontent2').html(' <img class="loadergif" src="images/loader.gif"  />');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas,{option:tyc_ref});
});

$('#paymentclick').click(function(){
	
	var datas=$(this).data('values');
	var tyc_ref=$(this).data('tyc_ref');
	$('#taskreminderheaders').html('Task');
	$('#projectmodal2').modal('show').find('#modalcontent2').html(' <img class="loadergif" src="images/loader.gif"  />');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas,{option:tyc_ref});
});

$('#paymentsourcerclick').click(function(){
	
	var datas=$(this).data('values');
	//$('#taskreminderheaders').html('Task');
	$('#projectmodal2').modal('show').find('#modalcontent2').html('<img class="loadergif" src="images/loader.gif"  /> ');
	$('#projectmodal2').modal('show').find('#modalcontent2').load(datas);
});






$(function () {
    $("#example1").DataTable({
        "aaSorting": [],
		"pagingType": "simple",
		"responsive": "true",
		
    });
    $("#project_table").DataTable({
        "aaSorting": [],
		"pagingType": "simple",
		"responsive": "true",
		
    });
    $("#invoice_table").DataTable({
        "aaSorting": [],
		"pagingType": "simple",
		"responsive": "true",
		
    });
    $("#order_table").DataTable({
        "aaSorting": [],
		"pagingType": "simple",
		"responsive": "true",
		
    });
    $("#all_table").DataTable({
        "aaSorting": [],
		"pagingType": "simple",
		"responsive": "true",
		
    });
	
	
	
	// display table on dashboard
	
	$("#user_table_length").html('<span id="newuser" class="btn btn-black">New User</span>');
	
	

   
  });

$(function () {

  "use strict";

  //Make the dashboard widgets sortable Using jquery UI
  
	


  //bootstrap WYSIHTML5 - text editor
  //$(".textarea").wysihtml5();

  /*$('.daterange').daterangepicker({
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
  }, function (start, end) {
    window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  });*/

  /* jQueryKnob */
  //$(".knob").knob();

  //jvectormap data
  var visitorsData = {
    "US": 398, //USA
    "SA": 400, //Saudi Arabia
    "CA": 1000, //Canada
    "DE": 500, //Germany
    "FR": 760, //France
    "CN": 300, //China
    "AU": 700, //Australia
    "BR": 600, //Brazil
    "IN": 800, //India
    "GB": 320, //Great Britain
    "RU": 3000 //Russia
  };
  //World map by jvectormap
 /* $('#world-map').vectorMap({
    map: 'world_mill_en',
    backgroundColor: "transparent",
    regionStyle: {
      initial: {
        fill: '#e4e4e4',
        "fill-opacity": 1,
        stroke: 'none',
        "stroke-width": 0,
        "stroke-opacity": 1
      }
    },
    series: {
      regions: [{
        values: visitorsData,
        scale: ["#92c1dc", "#ebf4f9"],
        normalizeFunction: 'polynomial'
      }]
    },
    onRegionLabelShow: function (e, el, code) {
      if (typeof visitorsData[code] != "undefined")
        el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
    }
  });
*/
  //Sparkline charts
 /* var myvalues = [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021];
  $('#sparkline-1').sparkline(myvalues, {
    type: 'line',
    lineColor: '#92c1dc',
    fillColor: "#ebf4f9",
    height: '50',
    width: '80'
  });
  myvalues = [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921];
  $('#sparkline-2').sparkline(myvalues, {
    type: 'line',
    lineColor: '#92c1dc',
    fillColor: "#ebf4f9",
    height: '50',
    width: '80'
  });
  myvalues = [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21];
  $('#sparkline-3').sparkline(myvalues, {
    type: 'line',
    lineColor: '#92c1dc',
    fillColor: "#ebf4f9",
    height: '50',
    width: '80'
  });

  //The Calender
  $("#calendar").datepicker();

  //SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').slimScroll({
    height: '250px'
  });

  /* Morris.js Charts 
  // Sales chart
  var area = new Morris.Area({
    element: 'revenue-chart',
    resize: true,
    data: [
      {y: '2011 Q1', item1: 2666, item2: 2666},
      {y: '2011 Q2', item1: 2778, item2: 2294},
      {y: '2011 Q3', item1: 4912, item2: 1969},
      {y: '2011 Q4', item1: 3767, item2: 3597},
      {y: '2012 Q1', item1: 6810, item2: 1914},
      {y: '2012 Q2', item1: 5670, item2: 4293},
      {y: '2012 Q3', item1: 4820, item2: 3795},
      {y: '2012 Q4', item1: 15073, item2: 5967},
      {y: '2013 Q1', item1: 10687, item2: 4460},
      {y: '2013 Q2', item1: 8432, item2: 5713}
    ],
    xkey: 'y',
    ykeys: ['item1', 'item2'],
    labels: ['Item 1', 'Item 2'],
    lineColors: ['#a0d0e0', '#3c8dbc'],
    hideHover: 'auto'
  });
  var line = new Morris.Line({
    element: 'line-chart',
    resize: true,
    data: [
      {y: '2011 Q1', item1: 2666},
      {y: '2011 Q2', item1: 2778},
      {y: '2011 Q3', item1: 4912},
      {y: '2011 Q4', item1: 3767},
      {y: '2012 Q1', item1: 6810},
      {y: '2012 Q2', item1: 5670},
      {y: '2012 Q3', item1: 4820},
      {y: '2012 Q4', item1: 15073},
      {y: '2013 Q1', item1: 10687},
      {y: '2013 Q2', item1: 8432}
    ],
    xkey: 'y',
    ykeys: ['item1'],
    labels: ['Item 1'],
    lineColors: ['#efefef'],
    lineWidth: 2,
    hideHover: 'auto',
    gridTextColor: "#fff",
    gridStrokeWidth: 0.4,
    pointSize: 4,
    pointStrokeColors: ["#efefef"],
    gridLineColor: "#efefef",
    gridTextFamily: "Open Sans",
    gridTextSize: 10
  });

  //Donut Chart
  var donut = new Morris.Donut({
    element: 'sales-chart',
    resize: true,
    colors: ["#3c8dbc", "#f56954", "#00a65a"],
    data: [
      {label: "Download Sales", value: 12},
      {label: "In-Store Sales", value: 30},
      {label: "Mail-Order Sales", value: 20}
    ],
    hideHover: 'auto'
  });

  //Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    donut.redraw();
    line.redraw();
  });

  /* The todo list plugin 
  $(".todo-list").todolist({
    onCheck: function (ele) {
      window.console.log("The element has been checked");
      return ele;
    },
    onUncheck: function (ele) {
      window.console.log("The element has been unchecked");
      return ele;
    }
  });
  */
  $("#wizard-picture").change(function () {
        readURL(this);
    });
  
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.folder-image').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

});
	
	
	
	
	})
