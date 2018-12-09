<?php
$wpspf_search_pr_list_view      		= (get_option('wpspf_search_pr_list_view')) ? get_option('wpspf_search_pr_list_view') : 'both';
$wpspf_search_by_pr_title      			= (get_option('wpspf_search_by_pr_title')) ? get_option('wpspf_search_by_pr_title') : 'enable';
$wpspf_search_title_text                = (get_option('wpspf_search_title_text')) ? get_option('wpspf_search_title_text') : '';
$wpspf_search_min_typed_char_pr_title   = 5;
$wpspf_search_by_pr_sku      			= (get_option('wpspf_search_by_pr_sku')) ? get_option('wpspf_search_by_pr_sku') : 'enable';
$wpspf_search_min_typed_char_pr_sku     = 3;
$wpspf_search_title_text2               = (get_option('wpspf_search_title_text2')) ? get_option('wpspf_search_title_text2') : '';


$wpspf_search_pr_title_placeholder    		= 'Type Product Name Here...';
$wpspf_search_pr_sku_placeholder      		= 'Type Product SKU Here. Like sk01, sk02 etc.';
$wpspf_search_loader 						=  4;
$wpspf_search_cart_btn_bck_color      		= '#000';
$wpspf_search_cart_btn_txt_color      		= '#fff';
$wpspf_search_cart_btn_txt_hover_color  	= '#686857';
$wpspf_search_read_more_btn_bck_color      	= '#E8B26B';
$wpspf_search_read_more_btn_txt_color      	= '#fff';
$wpspf_search_read_more_btn_txt_hover_color = '#686857';
$wpspf_search_custom_css 					= '';

?>
<div id="tab1" class="tab active">
    <h3><?php _e('General','wpspf'); ?></h3>
    <span class="wpspf_search_reset"><img src="<?php echo WPSPF_AST_PATH.'reset.png'; ?>" /></span>
    <div class="container">
        <div class="control-group">
            <h1><?php _e('Search By Product Title','wpspf');?></h1>
            <div class="select">
                <select name="wpspf_search_by_pr_title">
                    <option value="enable" <?php if($wpspf_search_by_pr_title=='enable'){echo "selected";} ?>>Enable</option>
                    <option value="disable" <?php if($wpspf_search_by_pr_title=='disable'){echo "selected";} ?>>Disable</option>
                </select>
                <div class="select__arrow"></div>
            </div>
            <h1><?php _e('Title, before Product Title search box.','wpspf'); ?></h1>
            <input value="<?php echo $wpspf_search_title_text; ?>" name="wpspf_search_title_text" id="wpspf_search_title_text" class="input-box" type="text"/>
            <h1><?php _e('Minimum Number Of Typed Character, to start Product Title search','wpspf');?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_min_typed_char_pr_title; ?>" name="wpspf_search_min_typed_char_pr_title" id="wpspf_search_min_typed_char_pr_title" class="input-box" type="number"/>
            </div>
            <h1><?php _e('Search By Product SKU','wpspf'); ?></h1>
            <div class="select">
                <select name="wpspf_search_by_pr_sku">
                    <option value="enable" <?php if($wpspf_search_by_pr_sku=='enable'){echo "selected";} ?>>Enable</option>
                    <option value="disable" <?php if($wpspf_search_by_pr_sku=='disable'){echo "selected";} ?>>Disable</option>
                </select>
                <div class="select__arrow"></div>
            </div>
            <h1><?php _e('Title, before Product SKU search box.','wpspf'); ?></h1>
            <input value="<?php echo $wpspf_search_title_text2; ?>" name="wpspf_search_title_text2" id="wpspf_search_title_text2" class="input-box" type="text"/>
            <h1><?php _e('Minimum Number Of Typed Character, to start Product SKU search','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_min_typed_char_pr_sku; ?>" name="wpspf_search_min_typed_char_pr_sku" id="wpspf_search_min_typed_char_pr_sku" class="input-box" type="number"/>
            </div>
            <h1><?php _e('Product Listing View','wpspf'); ?></h1>
            <div class="select">
                <select name="wpspf_search_pr_list_view">
                    <option value="none" <?php if($wpspf_search_pr_list_view=='none'){echo "selected";} ?>>None</option>
                    <option value="grid" <?php if($wpspf_search_pr_list_view=='grid'){echo "selected";} ?>>Grid</option>
                    <option value="list" <?php if($wpspf_search_pr_list_view=='list'){echo "selected";} ?>>List</option>
                    <option value="both" <?php if($wpspf_search_pr_list_view=='both'){echo "selected";} ?>>Grid - List Switcher</option>
                </select>
                <div class="select__arrow"></div>
            </div>
        </div>
    </div>
    <h3>Style</h3>
    <div class="container">
        <div class="control-group">
            <h1><?php _e('Placeholder of Product Title Search Box','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_pr_title_placeholder; ?>" name="wpspf_search_pr_title_placeholder" id="wpspf_search_pr_title_placeholder" class="input-box" type="text"/>
            </div>
            <h1><?php _e('Placeholder of Product SKU Search Box','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_pr_sku_placeholder; ?>" name="wpspf_search_pr_sku_placeholder" id="wpspf_search_pr_sku_placeholder" class="input-box" type="text"/>
            </div>
            <h1><?php _e('Add To Cart Button Background Color','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_cart_btn_bck_color; ?>" name="wpspf_search_cart_btn_bck_color" id="wpspf_search_cart_btn_bck_color" class="color-field" type="text"/>
            </div>
            <h1><?php _e('Add To Cart Button Text Color','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_cart_btn_txt_color; ?>" name="wpspf_search_cart_btn_txt_color" id="wpspf_search_cart_btn_txt_color" class="color-field" type="text" />
            </div>
            <h1><?php _e('Add To Cart Button Text Hover Color','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_cart_btn_txt_hover_color; ?>" name="wpspf_search_cart_btn_txt_hover_color" id="wpspf_search_cart_btn_txt_hover_color" class="color-field" type="text"/>
            </div>
            <h1><?php _e('Read More Button Background Color','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_read_more_btn_bck_color; ?>" name="wpspf_search_read_more_btn_bck_color" id="wpspf_search_read_more_btn_bck_color" class="color-field" type="text"/>
            </div>
            <h1><?php _e('Read More Button Text Color','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_read_more_btn_txt_color; ?>" name="wpspf_search_read_more_btn_txt_color" id="wpspf_search_read_more_btn_txt_color" class="color-field" type="text"/>
            </div>
            <h1><?php _e('Read More Button Text Hover Color','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <div class="select">
                <input value="<?php echo $wpspf_search_read_more_btn_txt_hover_color; ?>" name="wpspf_search_read_more_btn_txt_hover_color" id="wpspf_search_read_more_btn_txt_hover_color" class="color-field" type="text"/>
            </div>
        </div>
        <div class="control-group">
            <h1><?php _e('Loader Image','wpspf'); ?></h1><span style="font-size:12px; font-style:italic; color:red;"><?php _e('Available for Premium version,','wpspf'); ?> <a href="http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/" target="_blank">Buy Now</a></span>
            <?php for($i=1; $i<=10; $i++){ ?>
                <label class="control control--radio">
                    <img src="<?php echo WPSPF_AST_PATH.'loader-'.$i.'.gif'; ?>" />
                    <input type="radio" name="wpspf_search_loader" value="<?php echo $i; ?>" <?php if($wpspf_search_loader==$i){echo 'checked';} ?>/>
                    <div class="control__indicator"></div>
                </label>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
var $ =jQuery.noConflict();
$(".wpspf_search_reset").click(function(){
	if (confirm('Are You Want To Reset The Settings of Search?')) {
      	$.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    'action':'wpspf_settings_reset',
                    'settings_elements' : 'search'
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

