<?php

/**
 * Fired during plugin deactivation.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/includes
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG_Deactivator class.
 *
 * @since    1.0.0
 */
class AIOVG_Deactivator {

	/**
	 * Called when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
	
		delete_transient( 'aiovg_welcome_redirect' );
		delete_option( 'rewrite_rules' );
		
	}

}
