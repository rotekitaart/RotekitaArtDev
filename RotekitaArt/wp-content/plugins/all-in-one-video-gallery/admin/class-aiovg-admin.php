<?php

/**
 * The admin-specific functionality of the plugin.
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
 * AIOVG_Admin class.
 *
 * @since    1.0.0
 */
class AIOVG_Admin {
	
	/**
	 * Check and update plugin options to the latest version.
	 *
	 * @since    1.5.2
	 */
	public function manage_upgrades() {

		if ( AIOVG_PLUGIN_VERSION !== get_option( 'aiovg_version' ) ) {
		
			$defaults = aiovg_get_default_settings();
			
			// Insert the player brand settings			
			if ( false == get_option( 'aiovg_brand_settings' ) ) {
				add_option( 'aiovg_brand_settings', $defaults['aiovg_brand_settings'] );
			}
			
			// Insert the privacy settings			
			if ( false == get_option( 'aiovg_privacy_settings' ) ) {
				add_option( 'aiovg_privacy_settings', $defaults['aiovg_privacy_settings'] );
			}
			
			// Update the plugin version
			update_option( 'aiovg_version', AIOVG_PLUGIN_VERSION );
		
		}

	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'wp-color-picker' );
		
		wp_enqueue_style( AIOVG_PLUGIN_SLUG . '-magnific-popup', AIOVG_PLUGIN_URL . 'public/assets/css/magnific-popup.css', array(), '1.1.0', 'all' );
		wp_enqueue_style( AIOVG_PLUGIN_SLUG, AIOVG_PLUGIN_URL . 'admin/assets/css/aiovg-admin.css', array(), AIOVG_PLUGIN_VERSION, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
		
		wp_enqueue_script( AIOVG_PLUGIN_SLUG . '-magnific-popup', AIOVG_PLUGIN_URL . 'public/assets/js/magnific-popup.min.js', array( 'jquery' ), '1.1.0', false );
		wp_enqueue_script( AIOVG_PLUGIN_SLUG, AIOVG_PLUGIN_URL . 'admin/assets/js/aiovg-admin.js', array( 'jquery' ), AIOVG_PLUGIN_VERSION, false );

	}
	
	/**
	 * Add a settings link on the plugin listing page.
	 *
	 * @since     1.0.0
	 * @param     array     $links    An array of plugin action links.
	 * @return    string    $links    Array of filtered plugin action links.
	 */
	public function plugin_action_links( $links ) {

		$settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=aiovg_videos&page=aiovg_settings' ), __( 'Settings', 'all-in-one-video-gallery' ) );
        array_unshift( $links, $settings_link );
		
    	return $links;

	}
	
	/**
	 * Display admin notice.
	 *
	 * @since    1.0.0
	 */
	public function admin_notice() { 
		
		if ( false == get_option( 'aiovg_admin_notice_dismissed' ) ) : ?>    
            <div id="aiovg-admin-notice" class="notice notice-info is-dismissible" data-security="<?php echo wp_create_nonce( 'aiovg_admin_notice_nonce' ); ?>">
                <p><strong><?php _e( 'All-in-One Video Gallery', 'all-in-one-video-gallery' ); ?></strong></p>
                <p>
                    <a href="https://plugins360.com/all-in-one-video-gallery/documentation/" target="_blank"><?php _e( 'Online Documentation', 'all-in-one-video-gallery' ); ?></a> | 
                    <a href="https://plugins360.com/support/" target="_blank"><?php _e( 'Contact Support', 'all-in-one-video-gallery' ); ?></a> | 
                    <a href="https://plugins360.com/all-in-one-video-gallery/add-ons/" target="_blank"><?php _e( 'Premium Add-ons', 'all-in-one-video-gallery' ); ?></a>
                </p>
            </div>        
		<?php endif;
		
	}
	
	/**
	 * Dismiss admin notice.
	 *
	 * @since    1.0.0
	 */
	public function ajax_callback_dismiss_admin_notice() {
	
		check_ajax_referer( 'aiovg_admin_notice_nonce', 'security' );
		
		add_option( 'aiovg_admin_notice_dismissed', 1 );
		wp_die();
	
	}	

}