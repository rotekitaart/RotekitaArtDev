<?php
add_action( 'wp_ajax_wpspf_pr_search_by_title', 'wpspf_pr_search_by_title' );
add_action( 'wp_ajax_nopriv_wpspf_pr_search_by_title', 'wpspf_pr_search_by_title' );
function wpspf_pr_search_by_title(){
    $wpspf_search_cart_btn_bck_color            = '#000';
    $wpspf_search_cart_btn_txt_color            = '#fff';
    $wpspf_search_cart_btn_txt_hover_color      = '#686857';
    $wpspf_search_read_more_btn_bck_color       = '#E8B26B';
    $wpspf_search_read_more_btn_txt_color       = '#fff';
    $wpspf_search_read_more_btn_txt_hover_color = '#686857';

    $wpspf_search_pr_list_view                  = (get_option('wpspf_search_pr_list_view')) ? get_option('wpspf_search_pr_list_view') : 'both';

    $search_term = $_POST['search_keyword'];
    if($_POST['search_by']=='title'){
        $args = array(
            'post_type' => 'product',
            's' => $search_term,
            'post_status' => 'publish',
            'orderby' => 'title'
        );
    }
    if($_POST['search_by']=='sku'){
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'meta_query' => array(
                    array(
                       'key' => '_sku',
                       'value' => $search_term,
                       'compare' => 'LIKE'
                     )
                ),
        );
    }
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) {
        ?>
        <div id="wps-pf-wrap-product">
            <header>
                <span class="list-style-buttons">
                    <?php if($wpspf_search_pr_list_view == 'both'){ ?>
                    <a href="#" id="gridview" class="switcher"><img src="<?php echo WPSPF_AST_PATH; ?>grid-view.png" alt="Grid"></a>
                    <a href="#" id="listview" class="switcher active"><img src="<?php echo WPSPF_AST_PATH; ?>list-view-active.png" alt="List"></a>
                    <?php } ?>
                    <a href="javascript:void(0)" onclick="close()" id="wpspf_pr_result_close"><img src="<?php echo WPSPF_AST_PATH; ?>cross.png" alt="Close"></a>
                </span>
                <h1> <?php _e('Available Product(s)', 'wpspf');?></h1>
            </header>
            <ul id="products" class="<?php if($wpspf_search_pr_list_view == 'grid'){ echo 'grid';}else{ echo 'list';} ?> clearfix">
                <?php
                $class = '';
                while ( $the_query->have_posts() ) {
                    $class = ($class == 'alt' ? '' : 'alt');
                    $the_query->the_post();
                    $img_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                    
                    ?>
                    <li class="clearfix <?php echo $class ; ?>">
                        <section class="left">
                            <img src="<?php echo $img_url; ?>">
                        </section>
                        <section class="right">
                            <h3><?php echo get_the_title(); ?></h3>
                            <?php 
                                if(strlen(get_the_content()) > 19){
                                    $content = substr(get_the_content(), 0 , 19).'...';
                                }
                                else{
                                    $content = get_the_content();
                                }
                            ?>
                            <span class="meta"><?php echo $content;  ?></span>
                            <span class="price">
                            <?php
                                global $woocommerce;
                                $currency = get_woocommerce_currency_symbol();
                                $price = get_post_meta( get_the_ID(), '_regular_price', true);
                                $sale = get_post_meta( get_the_ID(), '_sale_price', true);
                                ?>
                                 
                                <?php if($sale) : ?>
                                    <del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?>    
                                <?php elseif($price) : ?>
                                    <?php echo $currency; echo $price; ?>    
                                <?php endif; ?>
                            </span>
                        </section>
                        <span class="darkview">
                            <a href="<?php echo get_permalink(get_the_ID()); ?>" class="read_more_button"><?php _e('Read More','wpspf');?></a>
                            <a href="<?php echo site_url();  ?>/cart/?add-to-cart=<?php echo get_the_ID(); ?>" class="add_to_cart_button"><?php _e('Add To Cart','wpspf');?></a>
                        </span>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
            } else {
                ?>
                    <div id="wps-pf-wrap-product">
                        <header>
                            <h1><?php _e('No Product Found','wpspf'); ?></h1>
                        </header>
                    </div>
                <?php
            }
        wp_reset_postdata();
    ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#wpspf_pr_result_close").click(function(){
                $("#wpsps_pr_title_search_result").html('');
                $("#wpsps_pr_title_search_result").hide();
            });

            $("a.switcher").bind("click", function(e){
                e.preventDefault();
                
                var theid = $(this).attr("id");
                var theproducts = $("ul#products");
                var classNames = $(this).attr('class').split(' ');
                
                var gridthumb = "<?php echo WPSPF_AST_PATH; ?>/products/grid-default-thumb.png";
                var listthumb = "<?php echo WPSPF_AST_PATH; ?>/products/list-default-thumb.png";
                
                if($(this).hasClass("active")) {
                    return false;
                } else {
                    if(theid == "gridview") {
                        $(this).addClass("active");
                        $("#listview").removeClass("active");
                    
                        $("#listview").children("img").attr("src","<?php echo WPSPF_AST_PATH; ?>/list-view.png");
                    
                        var theimg = $(this).children("img");
                        theimg.attr("src","<?php echo WPSPF_AST_PATH; ?>/grid-view-active.png");
                    
                        theproducts.removeClass("list");
                        theproducts.addClass("grid");
                    
                        $("img.thumb").attr("src",gridthumb);
                    }
                    
                    else if(theid == "listview") {
                        $(this).addClass("active");
                        $("#gridview").removeClass("active");
                            
                        $("#gridview").children("img").attr("src","<?php echo WPSPF_AST_PATH; ?>/grid-view.png");
                            
                        var theimg = $(this).children("img");
                        theimg.attr("src","<?php echo WPSPF_AST_PATH; ?>/list-view-active.png");
                            
                        theproducts.removeClass("grid")
                        theproducts.addClass("list");
                        $("img.thumb").attr("src",listthumb);
                    } 
                }
            });
        });
    </script>
    <style type="text/css">
        #wps-pf-wrap-product .darkview .read_more_button{
            background: <?php echo $wpspf_search_read_more_btn_bck_color; ?> !important;
            border: solid 1px <?php echo $wpspf_search_read_more_btn_bck_color; ?> !important;
            color: <?php echo $wpspf_search_read_more_btn_txt_color; ?> !important;
        }
        #wps-pf-wrap-product .darkview .read_more_button:hover{
            color: <?php echo $wpspf_search_read_more_btn_txt_hover_color; ?> !important;
        }

        #wps-pf-wrap-product .darkview .add_to_cart_button{
            background: <?php echo $wpspf_search_cart_btn_bck_color; ?> !important;
            border: solid 1px <?php echo $wpspf_search_cart_btn_bck_color; ?> !important;
            color: <?php echo $wpspf_search_cart_btn_txt_color; ?> !important;
        }
        #wps-pf-wrap-product .darkview .add_to_cart_button:hover{
            color: <?php echo $wpspf_search_cart_btn_txt_hover_color; ?> !important;
        }
    </style>
    <?php
    exit;
}


add_action( 'wp_ajax_wpspf_settings_reset', 'wpspf_settings_reset' );
function wpspf_settings_reset(){
    switch ($_POST['settings_elements']) {
        case 'search':
            delete_option('wpspf_search_pr_list_view');
            delete_option('wpspf_search_by_pr_title');
            delete_option('wpspf_search_by_pr_sku');
            delete_option('wpspf_search_title_text');
            delete_option('wpspf_search_title_text2');
            
            break;
        case 'attribute':
            delete_option('wpspf_filter_by_pr_attr');
            delete_option('wpspf_attr');
            break;
        case 'category':
            delete_option('wpspf_filter_by_pr_cat');
            delete_option('wpspf_cat_title_text');
            
            
            break;
        default:
            break;
        
    }
}

add_action( 'wp_ajax_wpspf_get_all_attributes', 'wpspf_get_all_attributes' );
function wpspf_get_all_attributes(){
    if(!$_POST['counter']){
        exit;
    }else{
        $counter = $_POST['counter'];
    }
    global $wpdb;
    $attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name != '' ORDER BY attribute_name ASC;" );
    
    ?>
    <h1>Status</h1>
    <div class="select">
        <select name="wpspf_attr[<?php echo $counter;?>][status]">
            <option value="enable" selected>Enable</option>
            <option value="disable">Disable</option>
        </select>
    </div>
    <h1>Reset</h1>
    <div class="select">
        <select name="wpspf_attr[<?php echo $counter;?>][reset]">
            <option value="enable" selected>Enable</option>
            <option value="disable">Disable</option>
        </select>
    </div>
    <h1>Title</h1>
    <div class="select">
        <input type="text" name="wpspf_attr[<?php echo $counter;?>][title]" />
    </div>
    <h1>Attribute</h1>
    <div class="select">
        <select name="wpspf_attr[<?php echo $counter;?>][tax_id]" onchange="set_terms_color_fields(<?php echo $counter; ?>)" id="wpspf_tax_<?php echo $counter; ?>">
            <?php foreach($attribute_taxonomies as $tax){?>
                <option value="<?php echo $tax->attribute_id; ?>"><?php echo $tax->attribute_label; ?></option>
            <?php } ?>
        </select>
    </div>
    <h1>Type</h1>
    <div class="select">
        <select name="wpspf_attr[<?php echo $counter;?>][tax_type]" onchange="set_terms_color_fields(<?php echo $counter; ?>)" id="wpspf_tax_type_<?php echo $counter; ?>">
            <option value="checkbox">CheckBox</option>
            <option value="dropdown">DropDown</option>
            <option value="radio">RadioButton</option>
            <option value="color">Colour / Color Field</option>
        </select>
    </div>
    <div class="wpspf_assign_color_feld_<?php echo $counter; ?>" style="display:none;">
        <h1>Assign Colour / Color Field For Each Value</h1>
        <?php $cv_counter = 1; ?>
        <?php foreach($attribute_taxonomies as $tax){?>
        <div id="pa_<?php echo $tax->attribute_id; ?>_<?php echo $counter; ?>" style="display:none;" class="wpspf_tax_color_field_<?php echo $counter; ?>">
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
                        <input type="text" name="wpspf_attr[<?php echo $counter;?>][color_value][<?php echo $cv_counter;?>][term_value]" class="wpspf_terms_assign_color" />
                    </div>
                <?php $cv_counter++; ?>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <script type="text/javascript">
        $('.wpspf_terms_assign_color').wpColorPicker();
    </script>
    <?php
    exit;
}

add_action( 'wp_ajax_wpspf_pr_filter_by_attribute', 'wpspf_pr_filter_by_attribute' );
add_action( 'wp_ajax_nopriv_wpspf_pr_filter_by_attribute', 'wpspf_pr_filter_by_attribute' );
function wpspf_pr_filter_by_attribute(){
    if(!$_POST['datastring'])
        exit;
    $term_ids = '';
    $parameters = explode('&',$_POST['datastring']);
    global $wpdb;
    for($i=0;$i<count($parameters);$i++){
        if (strpos($parameters[$i], '=') > -1){
            $temp_arr = explode("=",$parameters[$i]);
            if($temp_arr[1] == 'reset'){
                $temp_arr[1] = '';
            }
            if($temp_arr[1] !='0' && $temp_arr[1] !=''){
                global $wpdb;
                $taxonomy = $wpdb->get_results( "SELECT taxonomy FROM ".$wpdb->prefix."term_taxonomy WHERE term_id = ".$temp_arr[1] );
                $taxonomy_name = $taxonomy[0]->taxonomy;
                $tax_query[] = array(
                        'taxonomy'  => $taxonomy_name,
                        'field'     => 'id',
                        'terms'     => $temp_arr[1],
                        'operator'  => 'IN'
                    );
            }
        }
    }
    if (empty($tax_query)) {
        echo "refresh";
        exit;
    }
    else{
        $tax_query['relation'] = 'AND';
    }
    $args = array(
                'post_type'        => 'product',
                'tax_query'        => $tax_query,
                'post__not_in'     => array( $post_id ),
                'posts_per_page'   => -1,
            );
    $products = new WP_Query( $args );
    if ( $products->have_posts() ) {
        if (function_exists('woocommerce_product_loop_start')) {
            woocommerce_product_loop_start();
        }

        while ( $products->have_posts() ) {
            $products->the_post();
            wc_get_template_part('content', 'product');
        }
    }
    else{
        wc_get_template('loop/no-products-found.php');
    }
    if (function_exists('woocommerce_product_loop_end')) {
        woocommerce_product_loop_end();
    }
    wp_reset_postdata();
    wp_reset_query();
    exit;
}

?>