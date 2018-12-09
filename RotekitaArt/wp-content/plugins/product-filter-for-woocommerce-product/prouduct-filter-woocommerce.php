<?php
/*
Plugin Name: Product Filter For WooCommerce Product (BASIC)
Plugin URI: http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/
Description:  Create Filters For Your WooCommerce Product and Set It In Your Sidebar of Shop Page. 
Version: 1.0.3
Author: wpsuperiors
Author URI: http://www.wpsuperiors.com/shop/product-filter-for-woocommerce-product/
Text Domain: wpspf
Domain Path: /languages
* WC requires at least: 3.4.0
* WC tested up to: 3.5.2
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
add_action( 'admin_init', 'wpspf_woo_active_check_basic' );
function wpspf_woo_active_check_basic() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        add_action( 'admin_notices', 'wpspf_active_failed_notice' );
        deactivate_plugins( plugin_basename( __FILE__ ) ); 
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
    
}

function wpspf_active_failed_notice(){
    ?>
    <div class="error">
        <p>
            <?php _e('Please Activate <b>WooCommerce</b> Plugin, For <b>Product Filter For WooCommerce Product</b> Plugin. <a href="http://wpsuperiors.com/knowledge-base/" target="_blank">Click Here</a> to know more.','wpspf'); ?>
        </p>
    </div>
<?php
}
define('WPSPF_INC_PATH', plugin_dir_path(__FILE__).'/includes/');
define('WPSPF_ELEM_PATH', plugin_dir_path(__FILE__).'/includes/elements/');
define('WPSPF_AST_PATH', plugin_dir_url( __FILE__ ).'assets/');
require WPSPF_INC_PATH.'widgets.php';
require WPSPF_INC_PATH.'ajax.php';
require WPSPF_INC_PATH.'admin.php';
add_action( 'widgets_init', function(){ register_widget( 'WPSPF_Widget_Basic' ); });
add_action('init','wps_pf_pr_filter_register');



function wps_pf_pr_filter_register(){
    wp_enqueue_style( 'wpspf-main-css-1', WPSPF_AST_PATH.'wpspf_pr_filter.css', array(), '1.1' );
    wp_enqueue_style( 'wpspf-main-css-1' );
    if( is_admin() ) { 
        wp_enqueue_style( 'wp-color-picker' ); 
        wp_enqueue_script( 'custom-script-handle', WPSPF_AST_PATH.'color-script.js', array( 'wp-color-picker' ), false, true ); 
        
        wp_register_script('wpspf-main-js-3', WPSPF_AST_PATH.'wpspf_pr_filter.js', array('jquery'),'1.1', true);
        wp_enqueue_script('wpspf-main-js-3');

    }
    else{
        wp_register_script('wpspf-main-js-4', WPSPF_AST_PATH.'wpspf_pr_filter_front.js', array('jquery'),'1.1', true);
        wp_enqueue_script('wpspf-main-js-4');

        wp_localize_script( 'wpspf-main-js-4', 'wpspf_js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wpspf_settings_links'  );
function wpspf_settings_links( $links ) {
    $plugin_links = array(
        '<a href="' . admin_url( 'edit.php?post_type=product&page=wpspf-product-filters' ) . '">' . __( 'Settings', 'wpspf' ) . '</a>',
        '<a href="http://www.wpsuperiors.com/contact-us/">' . __( 'Support', 'wpspf' ) . '</a>',
    );
    return array_merge( $plugin_links, $links );
}