var $ =jQuery.noConflict();

$(".color-box").on("click",function(){
	$(".color-box").removeClass('color-selected');
	//alert("Color: "+$(this).attr("data-id"));
	$(this).addClass('color-selected');
	$("#wpspf_color_value").val($(this).attr("data-id"));
	get_all_data();
});

$(".wpspf_attr_check").on("click",function(){
	//alert("Check: "+$(this).val());
	get_all_data();
});

$("#wpspf_attr_select").on("change",function(){
	//alert("Select: "+$(this).val());
	get_all_data();
});

$(".wpspf_attr_radio").on("click",function(){
	//alert("Radio: "+$(this).val());
	get_all_data();
});
function reset_attribute_front(id){
	
}

function get_all_data(){
	var datastring = $("#wpspf-attribute-filter").serialize();
	console.log(datastring);
	var data = {
	    'action': 'wpspf_pr_filter_by_attribute',
	    dataType: "html",
	    'datastring': datastring,
	};
	var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ) ?>";
	jQuery.post(wpspf_js_object.ajax_url, data, function(response) {

		$(".woocommerce-result-count").html('');
		$(".woocommerce-ordering").html('');
		$(".woocommerce-pagination").html('');
		if(response == 'refresh'){
			location.reload();
		}
		else{
			$(".products").html('');
			$(".products").html(response);
		}
		//alert(response);
	});
}

$('.wpspf-category ul').hide();
$('.wpspf-category li span').click(function() {
	$('.wpspf-category li span').removeClass('selected-category');
	var id = $(this).attr('data-id');
	//console.log(id);
	$("#wpspf_cat_id").val(id);
	$(this).addClass('selected-category');
	$(this).show();
	get_all_data();
});

$('.wpspf-category li').click(function() {
	//var id = $(this).attr('data-id');
	//console.log(id);
	$(this).removeClass('selected-category');
	if($(this).hasClass('has-subcategory'))
	{
		if($(this).hasClass('wpspf-category-collapse')){
	  		$(this).removeClass('wpspf-category-collapse');
	  		$(this).addClass('wpspf-category-expand');
	 	}
	  	else{
	  		$(this).removeClass('wpspf-category-expand');
	  		$(this).addClass('wpspf-category-collapse');
	  	}
	}
	$(this).children("ul").slideToggle();
	return false;

});

$("#wpspf_cat_id_selectbox").on("change",function(){
	get_all_data();
});