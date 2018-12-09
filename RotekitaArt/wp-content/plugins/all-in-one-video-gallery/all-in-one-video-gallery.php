<?php

/**
 * The plugin bootstrap file.
 *
 * @link           https://plugins360.com
 * @since          1.0.0
 * @package        AIOVG
 *
 * @wordpress-plugin
 * Plugin Name:    All-in-One Video Gallery
 * Plugin URI:     https://plugins360.com/all-in-one-video-gallery/
 * Description:    Responsive & Lightweight Video gallery plugin. No coding required. Add/Manage videos through a dedicated custom post interface, group them by categories, customize the front-end display using the shortcode builder as you need, provide the option for users to search videos, plus everything you will need to build a YouTube/Vimeo like video sharing website.
 * Version:        1.5.6
 * Author:         Team Plugins360
 * Author URI:     https://plugins360.com
 * License:        GPL-2.0+
 * License URI:    http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:    all-in-one-video-gallery
 * Domain Path:    /languages
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

// The current version of the plugin
if ( ! defined( 'AIOVG_PLUGIN_VERSION' ) ) {
    define( 'AIOVG_PLUGIN_VERSION', '1.5.6' );
}

// The unique identifier of the plugin
if ( ! defined( 'AIOVG_PLUGIN_SLUG' ) ) {
    define( 'AIOVG_PLUGIN_SLUG', 'all-in-one-video-gallery' );
}

// Path to the plugin directory
if ( ! defined( 'AIOVG_PLUGIN_DIR' ) ) {
    define( 'AIOVG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// URL of the plugin
if ( ! defined( 'AIOVG_PLUGIN_URL' ) ) {
    define( 'AIOVG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// The plugin file name
if ( ! defined( 'AIOVG_PLUGIN_FILE_NAME' ) ) {
    define( 'AIOVG_PLUGIN_FILE_NAME', plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-aiovg-activator.php
 */
function activate_aiovg() {

	require_once AIOVG_PLUGIN_DIR . 'includes/class-aiovg-activator.php';
	AIOVG_Activator::activate();
	
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-aiovg-deactivator.php
 */
function deactivate_aiovg() {

	require_once AIOVG_PLUGIN_DIR . 'includes/class-aiovg-deactivator.php';
	AIOVG_Deactivator::deactivate();
	
}

register_activation_hook( __FILE__, 'activate_aiovg' );
register_deactivation_hook( __FILE__, 'deactivate_aiovg' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require AIOVG_PLUGIN_DIR . 'includes/class-aiovg.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_aiovg() {

	$plugin = new AIOVG();
	$plugin->run();
	
}

run_aiovg();
