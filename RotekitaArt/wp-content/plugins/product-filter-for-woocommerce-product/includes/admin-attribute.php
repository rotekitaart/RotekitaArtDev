<?php
global $wpdb;
$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name != '' ORDER BY attribute_name ASC;" );
if(!empty($attribute_taxonomies))
{
	$wpspf_filter_by_pr_attr  = (get_option('wpspf_filter_by_pr_attr')) ? get_option('wpspf_filter_by_pr_attr') : 'enable';
	$wpspf_attrs = get_option('wpspf_attr') ? get_option('wpspf_attr') : '';
	?>
	<link rel='stylesheet' href='<?php echo WPSPF_AST_PATH.'bootstrap.css';?>'>
    <script type='text/javascript' src='<?php echo WPSPF_AST_PATH.'bootstrap.js'; ?>'></script>
	<div id="tab2" class="tab">
		<input type="hidden" id="wpspf_number_of_taxonomy" value="<?php echo count($attribute_taxonomies); ?>"/>
	    <h3><?php _e('General','wpspf'); ?></h3>
	    <span class="wpspf_attr_reset"><img src="<?php echo WPSPF_AST_PATH.'reset.png'; ?>" /></span>
	    <div class="container">
	    	<div class="control-group">
	    		<h1><?php _e('Filter By Product Attribute','wpspf'); ?></h1>
	    		<div class="select">
	                <select name="wpspf_filter_by_pr_attr">
	                    <option value="enable" <?php if($wpspf_filter_by_pr_attr=='enable'){echo "selected";} ?>>Enable</option>
	                    <option value="disable" <?php if($wpspf_filter_by_pr_attr=='disable'){echo "selected";} ?>>Disable</option>
	                </select>
	                <div class="select__arrow"></div>
	            </div>
	            <h1><?php _e('Attribute Settings','wpspf'); ?></h1>
	            <br />
				<a class="button button-primary" id="add_one_attr"><?php _e('Add One Attribute','wpspf'); ?></a>
				<a class="button button-primary" id="add_all_attr"><?php _e('Add All Attributes','wpspf'); ?></a> <span id="wpspf_add_all_attr_txt">Into Filter Sidebar</span>

				<div class="panel-body">
					<span id="wps_pf_wait_message" style="display:none;"><?php _e('Please Wait Your Attribute Settings Are Opening...','wpspf'); ?>','wpspf'); ?></span>
					<div class="panel-group" id="wpspf_attr_filters" role="tablist" aria-multiselectable="true">
						<?php $counter = 1; ?>
						<?php if($wpspf_attrs != ''){ ?>
							<?php foreach($wpspf_attrs as $attr){ ?>
								<?php
									global $wpdb;
    								$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name != '' ORDER BY attribute_name ASC;" );
									foreach($attribute_taxonomies as $atrr_tax){
										if($attr['tax_id'] == $atrr_tax->attribute_id){
											$name = $atrr_tax->attribute_label;
										}
									}
								?>
								<div class="col-sm-12" style="margin-bottom: 0;">
									<div class="panel panel-default" id="panel<?php echo $counter;?>">
										<div class="panel-heading" role="tab" id="heading<?php echo $counter;?>">
											<h4 class="panel-title">
												<a class="collapsed" id="panel-lebel<?php echo $counter;?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $counter;?>" aria-expanded="false" aria-controls="collapse<?php echo $counter;?>">Attribute: <?php echo $name; ?></a>
												<div class="actions_div" style="position: relative; top: -26px;">
													<a href="javascript:void(0)" accesskey="<?php echo $counter;?>" class="remove_ctg_panel exit-btn pull-right"><span class="glyphicon glyphicon-remove"></span></a>
												</div>
											</h4>
										</div>
										<div id="collapse<?php echo $counter;?>" class="panel-collapse collapse"role="tabpane<?php echo $counter;?>" aria-labelledby="heading<?php echo $counter;?>">
											<div class="panel-body">
												<h1><?php _e('Status','wpspf'); ?>','wpspf'); ?></h1>
											    <div class="select">
											        <select name="wpspf_attr[<?php echo $counter;?>][status]">
											            <option value="enable" <?php if($attr['status']=='enable'){echo 'selected';} ?>>Enable</option>
											            <option value="disable" <?php if($attr['status']=='disable'){echo 'selected';} ?>>Disable</option>
											        </select>
											    </div>
											    <h1><?php _e('Reset','wpspf'); ?>','wpspf'); ?></h1>
											    <div class="select">
											        <select name="wpspf_attr[<?php echo $counter;?>][reset]">
											            <option value="enable" <?php if($attr['reset']=='enable'){echo 'selected';} ?>>Enable</option>
											            <option value="disable" <?php if($attr['reset']=='disable'){echo 'selected';} ?>>Disable</option>
											        </select>
											    </div>
											    <h1><?php _e('Title','wpspf'); ?>','wpspf'); ?></h1>
											    <div class="select">
											        <input type="text" name="wpspf_attr[<?php echo $counter;?>][title]" value="<?php echo $attr['title'];?>"/>
											    </div>
											    <h1><?php _e('Attribute','wpspf'); ?>','wpspf'); ?></h1>
											    <div class="select">
											        <select name="wpspf_attr[<?php echo $counter;?>][tax_id]" onchange="set_terms_color_fields(<?php echo $counter; ?>)" id="wpspf_tax_<?php echo $counter; ?>">
											            <?php foreach($attribute_taxonomies as $tax){?>
											                <option value="<?php echo $tax->attribute_id; ?>" <?php if($attr['tax_id']==$tax->attribute_id){echo 'selected';} ?>><?php echo $tax->attribute_label; ?></option>
											            <?php } ?>
											        </select>
											    </div>
											    <h1><?php _e('Type','wpspf'); ?>','wpspf'); ?></h1>
											    <div class="select">
											        <select name="wpspf_attr[<?php echo $counter;?>][tax_type]" onchange="set_terms_color_fields(<?php echo $counter; ?>)" id="wpspf_tax_type_<?php echo $counter; ?>">
											            <option value="checkbox" <?php if($attr['tax_type']=='checkbox'){echo 'selected';} ?>>CheckBox</option>
											            <option value="dropdown" <?php if($attr['tax_type']=='dropdown'){echo 'selected';} ?>>DropDown</option>
											            <option value="radio" <?php if($attr['tax_type']=='radio'){echo 'selected';} ?>>RadioButton</option>
											            <option value="color" <?php if($attr['tax_type']=='color'){echo 'selected';} ?>>Colour / Color Field</option>
											        </select>
											    </div>
											    <div class="wpspf_assign_color_feld_<?php echo $counter; ?>" <?php if($attr['tax_type']=='color'){echo 'style="display:block;"';}else{echo 'style="display:none;"';} ?>>
										        <h1><?php _e('Assign Colour / Color Field For Each Values','wpspf'); ?>','wpspf'); ?></h1>
										        <?php $cv_counter = 1; ?>
										        <?php foreach($attribute_taxonomies as $tax){?>
										        <div id="pa_<?php echo $tax->attribute_id; ?>_<?php echo $counter; ?>" <?php if($attr['tax_id']==$tax->attribute_id){echo 'style="display:block;"';}else{echo 'style="display:none;"';} ?> class="wpspf_tax_color_field_<?php echo $counter; ?>">
										            <?php
										                $terms = get_terms( array(
										                    'taxonomy' => 'pa_'.$tax->attribute_name,
										                    'hide_empty' => false,
										                ) );
										                //print_r($terms);
										                
										                foreach($terms as $term){
										            ?>
										                    <h1><?php echo $term->name; ?>:</h1>
										                    <input type="hidden" name="wpspf_attr[<?php echo $counter;?>][color_value][<?php echo $cv_counter;?>][term_id]" value="<?php echo $term->term_id; ?>"/>
										                    <input type="hidden" name="wpspf_attr[<?php echo $counter;?>][color_value][<?php echo $cv_counter;?>][term_name]" value="<?php echo $term->name; ?>"/>
										                    <div class="select">    
										                        <input type="text" name="wpspf_attr[<?php echo $counter;?>][color_value][<?php echo $cv_counter;?>][term_value]" class="wpspf_terms_assign_color color-field" value="<?php echo $attr['color_value'][$cv_counter]['term_value']; ?>" />
										                    </div>
										                <?php $cv_counter++; ?>
										            <?php } ?>
										        </div>
										        <?php } ?>
										    </div>
										</div>
									</div>
									</div>
								</div>
								<?php $counter++; ?>
							<?php } ?>
						<?php } ?>
						<input type="hidden" id="wpspf_latest_counter" value="<?php echo $counter; ?>" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
}
else{
	_e("<div id='tab2' class='tab'><h3 style='color:red;'>No product attributes found. Please create product attributes.</h3></div>", 'wpspf');
}
?>
<script type="text/javascript">
var $ =jQuery.noConflict();
$(".wpspf_attr_reset").click(function(){
	if (confirm('Are You Want To Reset The Settings of Attribute?')) {
      	$.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    'action':'wpspf_settings_reset',
                    'settings_elements' : 'attribute'
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