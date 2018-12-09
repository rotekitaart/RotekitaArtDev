<?php

/**
 * Welcome page
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/admin
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG_Admin_Welcome class.
 *
 * @since    1.0.0
 */
class AIOVG_Admin_Welcome {
	
	/**
	 * Add welcome page sub menus.
	 *
	 * @since    1.0.0
	 */
	public function add_welcome_menus() {
	
		add_dashboard_page(
			__( 'About - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			__( 'About - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			'manage_aiovg_options',
			'aiovg_about',
			array( $this, 'display_welcome_content' )
		);
		
		add_dashboard_page(
			__( 'Support - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			__( 'Support - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			'manage_aiovg_options',
			'aiovg_support',
			array( $this, 'display_welcome_content' )
		);
		
		// Now remove the menus so plugins that allow customizing the admin menu don't show them
		remove_submenu_page( 'index.php', 'aiovg_about' );
		remove_submenu_page( 'index.php', 'aiovg_support' );
	
	}
	
	/**
	 * Display welcome page content.
	 *
	 * @since    1.0.0
	 */
	public function display_welcome_content() {
	
		$tabs = array(
			'aiovg_about'   => __( 'About', 'all-in-one-video-gallery' ),
			'aiovg_support' => __( 'Support', 'all-in-one-video-gallery' )
		);
		
		$active_tab = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : 'aiovg_about';
		
		require_once AIOVG_PLUGIN_DIR . 'admin/templates/welcome.php';
		
	}
	
	/**
	 * Welcome page redirect.
	 *
	 * Only happens once and if the site is not a network or multisite.
	 *
	 * @since    1.0.0
	 */
	public function welcome_page_redirect() {
	
		// Bail if no activation redirect transient is present
    	if ( ! get_transient( 'aiovg_welcome_redirect' ) ) {
        	return;
    	}
		
		// Delete the redirect transient
  		delete_transient( 'aiovg_welcome_redirect' );
		
		// Bail if activating from network or bulk sites
  		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
    		return;
  		}
		
		// Redirect to welcome page
  		wp_safe_redirect( admin_url( 'index.php?page=aiovg_about' ) );
	
	}
	
}