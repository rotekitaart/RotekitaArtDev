<?php
	$wpspf_filter_by_pr_cat  	   = 'enable';
	$wpspf_cat_title_text    	   = (get_option('wpspf_cat_title_text')) ? get_option('wpspf_cat_title_text') : '';
	$wpspf_filter_by_pr_cat_style  = 'hierchical';
	$wpspf_filter_by_pr_cat_empty  = 'yes';
	$wpspf_filter_by_pr_cat_count  = 'yes';

	$wpspf_filter_by_pr_cat_order_by   = 'default';
	$wpspf_filter_by_pr_cat_order      = 'default';

?>
<div id="tab3" class="tab">
    <h3><?php _e('General','wpspf'); ?></h3>
    <span class="wpspf_cat_reset"><img src="<?php echo WPSPF_AST_PATH.'reset.png'; ?>" /></span>
    <div class="container">
    	<div class="control-group">
    		<h1><?php _e('Filter By Product Category','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
    		<div class="select">
                <select name="wpspf_filter_by_pr_cat">
                    <option value="enable" <?php echo "selected"; ?>>Enable</option>
                    <option value="disable">Disable</option>
                </select>
                <div class="select__arrow"></div>
            </div>
            <h1><?php _e('Title, before Product Category Listings','wpspf'); ?></h1>
            <input value="<?php echo $wpspf_cat_title_text; ?>" name="wpspf_cat_title_text" id="wpspf_cat_title_text" class="input-box" type="text"/>
        	<h1><?php _e('Style','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
        	<div class="select">
                <select name="wpspf_filter_by_pr_cat_style">
                    <option value="hierchical" <?php echo "selected"; ?>>Hierchical</option>
                    <option value="list">List</option>
                    <option value="dropdown">Dropdown</option>
                </select>
                <div class="select__arrow"></div>
            </div>
           
            <h1><?php _e('Hide Empty Category','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
    		<div class="select">
                <select name="wpspf_filter_by_pr_cat_empty">
                    <option value="yes" <?php echo "selected"; ?>>Yes</option>
                    <option value="no">No</option>
                </select>
                <div class="select__arrow"></div>
            </div>
            <h1><?php _e('Show Product Count','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
    		<div class="select">
                <select name="wpspf_filter_by_pr_cat_count">
                    <option value="yes" <?php echo "selected"; ?>>Yes</option>
                    <option value="no">No</option>
                </select>
                <div class="select__arrow"></div>
            </div>
            <h1><?php _e('Order By','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
    		<div class="select">
                <select name="wpspf_filter_by_pr_cat_order_by">
                    <option value="default" <?php echo "selected"; ?>>Default</option>
                    <option value="name">Name</option>
                    <option value="ID">ID</option>
                </select>
                <div class="select__arrow"></div>
            </div>
            <h1><?php _e('Order','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
    		<div class="select">
                <select name="wpspf_filter_by_pr_cat_order">
                    <option value="default" <?php echo "selected"; ?>>Default</option>
                    <option value="ASC">Ascending</option>
                    <option value="DSC">Desecnding</option>
                </select>
                <div class="select__arrow"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var $ =jQuery.noConflict();
$(".wpspf_cat_reset").click(function(){
	if (confirm('Are You Want To Reset The Settings of Category?')) {
      	$.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    'action':'wpspf_settings_reset',
                    'settings_elements' : 'category'
                },
                dataType: "text",
                success: function(msg){
                    location.reload();
                }
            });
    }
    else{
    	return false;
    }
});
</script>