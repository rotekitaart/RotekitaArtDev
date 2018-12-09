<?php
class WPSPF_Attribute {

    public function __construct()
    {
        $this->attribute_html();
        
    }
    public function attribute_html(){
       $wpspf_attrs = get_option('wpspf_attr') ? get_option('wpspf_attr') : '';
        if($wpspf_attrs){
           foreach($wpspf_attrs as $attr){
                if($attr['status'] == 'enable')
                {
                    ?>
                    <div class='wpspf_attr_reset_front'>
                    <?php
                    echo "<h3>".$attr['title']."</h3>";
                    if($attr['reset'] == 'enable'){
                        ?>
                        <a href="javascript:void(0);" onclick="reset_attribute_front();">
                        </a>
                        <?php
                    }
                    ?>
                    </div>
                    <link rel='stylesheet' href='<?php echo WPSPF_AST_PATH.'wpspf-front-css.css';?>'>
                    <div class="container">
                            <?php
                            global $wpdb;
                            $attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name != '' ORDER BY attribute_name ASC;" );
                            foreach($attribute_taxonomies as $atrr_tax){
                                if($attr['tax_id'] == $atrr_tax->attribute_id){
                                    $attribute_name = $atrr_tax->attribute_name;
                                }
                            }
                            $terms = get_terms( array(
                                                    'taxonomy' => 'pa_'.$attribute_name,
                                                    'hide_empty' => false,
                                                ) );
                            switch ($attr['tax_type']) {
                                case 'color':
                                    WPSPF_Attribute::generate_color_tax_type_html($attr['color_value'],$terms);
                                    ?>
                                    <input type="hidden" name="wpspf_color_value" id="wpspf_color_value" value="" />
                                    <?php
                                    break;
                                
                                case 'checkbox':
                                    foreach($terms as $term){
                                    ?>
                                    <label class="control control--checkbox"><?php echo $term->name; ?>
                                      <input type="checkbox" class="wpspf_attr_check" name="wpspf_attr_check" value="<?php echo $term->term_id; ?>" />
                                      <div class="control__indicator"></div>
                                    </label>
                                    <?php
                                    }
                                    ?>
                                    <label class="control control--checkbox"><?php _e('None / Reset,','wpspf'); ?>
                                      <input type="checkbox" class="wpspf_attr_check" name="wpspf_attr_check" value="reset" />
                                      <div class="control__indicator"></div>
                                    </label>
                                    <?php
                                    break;

                                case 'dropdown':
                                    ?>
                                    <div class="select">
                                      <select name="wpspf_attr_select" id="wpspf_attr_select">
                                        <option value="0"><?php _e('Select Attribute,','wpspf'); ?></option>
                                        <?php foreach($terms as $term){ ?>
                                        <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                                        <?php } ?>
                                        <option value="reset"><?php _e('None / Reset,','wpspf'); ?></option>
                                      </select>
                                      <div class="select__arrow"></div>
                                    </div>
                                    <?php
                                    break;

                                case 'radio':
                                    foreach($terms as $term){
                                    ?>
                                    <label class="control control--radio"><?php echo $term->name; ?>
                                      <input type="radio" class="wpspf_attr_radio" name="wpspf_attr_radio" value="<?php echo $term->term_id; ?>"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                    <?php
                                    }
                                    ?>
                                    <label class="control control--radio"><?php _e('None / Reset,','wpspf'); ?>
                                      <input type="radio" class="wpspf_attr_radio" name="wpspf_attr_radio" value="reset"/>
                                      <div class="control__indicator"></div>
                                    </label>
                                    <?php
                                    break;

                                default:
                                    # code...
                                    break;
                            }
                            ?>
                    </div>
                    <?php
                }

           }
        }
    }
    public function generate_color_tax_type_html($color_values,$terms){
        foreach($terms as $term){
            foreach($color_values as $cv){
                if($cv['term_id'] == $term->term_id){
        ?>
                    <div class="color-box" data-id="<?php echo $term->term_id; ?>" style="background:<?php echo $cv['term_value']; ?>"></div>
                    
        <?php
                }
            }
        }
        ?>
        <div class="color-box reset-color-box" data-id="reset">
            <img src="<?php echo WPSPF_AST_PATH.'square-cross.png'; ?>" />
        </div>
        <?php
    }
    
}new WPSPF_Attribute;
