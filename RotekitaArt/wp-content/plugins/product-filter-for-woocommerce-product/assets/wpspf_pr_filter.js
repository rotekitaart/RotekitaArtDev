var $ =jQuery.noConflict();
$("#add_all_attr").click(function(){
	$("#add_one_attr").remove();
	$("#add_all_attr").remove();
	$("#wpspf_add_all_attr_txt").remove();
	var num_call = $("#wpspf_number_of_taxonomy").val();
	num_call++;
	var counter = $("#wpspf_latest_counter").val();
	generate_taxonomy_fields(num_call,counter);
});
function generate_taxonomy_fields(num_call,counter){
	var catgName = 'Attribute #'+counter;

	if(catgName != null){
		var ariaExpanded = false;
		var expandedClass = '';
		var collapsedClass = 'collapsed';
		if(counter==1){
			  ariaExpanded = true;
			  expandedClass = 'in';
			  collapsedClass = '';
		}
		var data = {
		    'action': 'wpspf_get_all_attributes',
		    'counter': counter,
		    'dataType': "html",
		};
		$('#wps_pf_wait_message').show();
		var content = '';
		jQuery.post(ajaxurl, data, function(response) {
			content = response;
			$("#wpspf_attr_filters").append('\
		  	<div class="col-sm-12" style="margin-bottom: 0;">'+
		  		'<div class="panel panel-default" id="panel'+ counter +'">'+
		     		'<div class="panel-heading" role="tab" id="heading'+ counter +'">'+
		     			'<h4 class="panel-title">' +
			 				'<a class="'+collapsedClass+'" id="panel-lebel'+ counter +'" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+ counter +'" ' +
			 				'aria-expanded="'+ariaExpanded+'" aria-controls="collapse'+ counter +'"> '+catgName+' </a>'+
			 				'<div class="actions_div" style="position: relative; top: -26px;">'+
			 					'<a href="javascript:void(0)" accesskey="'+ counter +'" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>' +
			 				'</div>'+
			 			'</h4>'+
			 		'</div>' +
			 		'<div id="collapse'+ counter +'" class="panel-collapse collapse '+expandedClass+'"role="tabpanel" aria-labelledby="heading'+ counter +'">'+
			 		'<div class="panel-body">'+ content +'</div>'+
			 	'</div>'+
			'</div>');
			
		counter++;
		$("#wpspf_latest_counter").val(counter);
		num_call--;
		if (num_call > 1) {
	      generate_taxonomy_fields(num_call,counter)  // call function agian
	    }
	    else{
	    	$('#wps_pf_wait_message').hide();
	    }

		});
	}
}

$(document).ready(function(){
    var counter = $("#wpspf_latest_counter").val();
	$("#add_one_attr").click(function(){ 
		$("#add_all_attr").remove();
		/*https://bootsnipp.com/snippets/Pajeb*/
    	var catgName = 'Attribute #'+counter;

		if(catgName != null){
			var ariaExpanded = false;
			var expandedClass = '';
			var collapsedClass = 'collapsed';
			if(counter==1){
				  ariaExpanded = true;
				  expandedClass = 'in';
				  collapsedClass = '';
			}
			var data = {
			    'action': 'wpspf_get_all_attributes',
			    'counter': counter,
			    'dataType': "html",
			};
			$('#wps_pf_wait_message').show();
			var content = '';
			jQuery.post(ajaxurl, data, function(response) {
				content = response;
				$("#wpspf_attr_filters").append('\
			  	<div class="col-sm-12" style="margin-bottom: 0;">'+
			  		'<div class="panel panel-default" id="panel'+ counter +'">'+
			     		'<div class="panel-heading" role="tab" id="heading'+ counter +'">'+
			     			'<h4 class="panel-title">' +
				 				'<a class="'+collapsedClass+'" id="panel-lebel'+ counter +'" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+ counter +'" ' +
				 				'aria-expanded="'+ariaExpanded+'" aria-controls="collapse'+ counter +'"> '+catgName+' </a>'+
				 				'<div class="actions_div" style="position: relative; top: -26px;">'+
				 					'<a href="javascript:void(0)" accesskey="'+ counter +'" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>' +
				 				'</div>'+
				 			'</h4>'+
				 		'</div>' +
				 		'<div id="collapse'+ counter +'" class="panel-collapse collapse '+expandedClass+'"role="tabpanel" aria-labelledby="heading'+ counter +'">'+
				 		'<div class="panel-body">'+ content +'</div>'+
				 	'</div>'+
				'</div>');
				$('#wps_pf_wait_message').hide();
			counter++;
			$("#wpspf_latest_counter").val(counter);
			});
			
			
		}
		
    });
	/*$("#wpspf_attr_filters").on("click",".remove_ctg_panel", function(e){ 
		if (confirm('Are you sure ?')) {
			var accesskey = $(this).attr('accesskey');
	        $('#panel'+accesskey).remove();
			counter--;
			$("#wpspf_latest_counter").val(counter);
		}
	});*/
});
function set_terms_color_fields(counter){
	$(".wpspf_tax_color_field_"+counter).hide();
	var type = $("#wpspf_tax_type_"+counter+" option:selected").val();
	var tax = $("#wpspf_tax_"+counter+" option:selected").val();
	if(type == 'color'){
		$(".wpspf_assign_color_feld_"+counter).show();
		$("#pa_"+tax+"_"+counter).show();
	}
	else{
		$(".wpspf_assign_color_feld_"+counter).hide();
	}
}

$("#wpspf_attr_filters").on("click",".remove_ctg_panel", function(e){ 
	 if (confirm('Are you sure ?')) {
			var counter = $("#wpspf_latest_counter").val();
			var accesskey = $(this).attr('accesskey');
		    $('#panel'+accesskey).remove();
			counter--;
			$("#wpspf_latest_counter").val(counter);
	}
});


/* Front */
$(".color-box").on("click",function(){
	alert($(this).attr("data-id"));
});