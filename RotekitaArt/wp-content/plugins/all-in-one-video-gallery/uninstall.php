<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://plugins360.com
 * @since      1.0.0
 *
 * @package    AIOVG
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$general_settings = get_option( 'aiovg_general_settings' );
if ( empty( $general_settings['delete_plugin_data'] ) ) {
	return;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/functions.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-aiovg-roles.php';

global $wpdb;

// Delete all the custom post types
$aiovg_post_types = array( 'aiovg_videos' );

foreach ( $aiovg_post_types as $post_type ) {

	$items = get_posts( array( 'post_type' => $post_type, 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids' ) );
	
	if ( count( $items ) ) {
		foreach ( $items as $item ) {
			aiovg_delete_video_attachments( $item );
			wp_delete_post( $item, true );
		}
	}
			
}

// Delete all the terms & taxonomies
$aiovg_taxonomies = array( 'aiovg_categories' );

foreach ( $aiovg_taxonomies as $taxonomy ) {

	$terms = $wpdb->get_results( $wpdb->prepare( "SELECT t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('%s') ORDER BY t.name ASC", $taxonomy ) );
	
	// Delete terms
	if ( count( $terms ) ) {
		foreach ( $terms as $term ) {
			aiovg_delete_category_attachments( $term->term_id );
			
			$wpdb->delete( $wpdb->term_taxonomy, array( 'term_taxonomy_id' => $term->term_taxonomy_id ) );
			$wpdb->delete( $wpdb->terms, array( 'term_id' => $term->term_id ) );
		}
	}
	
	// Delete taxonomies
	$wpdb->delete( $wpdb->term_taxonomy, array( 'taxonomy' => $taxonomy ), array( '%s' ) );

}

// Delete the plugin pages
if ( $aiovg_created_pages = get_option( 'aiovg_page_settings' ) ) {

	foreach ( $aiovg_created_pages as $page => $id ) {

		if ( $id > 0 ) {
			wp_delete_post( $id, true );
		}
	
	}

}

// Delete all the plugin options
$aiovg_settings = array(
	'aiovg_general_settings',
	'aiovg_player_settings',	
	'aiovg_brand_settings',
	'aiovg_image_settings',
	'aiovg_categories_settings',
	'aiovg_videos_settings',
	'aiovg_video_settings',
	'aiovg_privacy_settings',
	'aiovg_permalink_settings',	
	'aiovg_socialshare_settings',
	'aiovg_page_settings',	
	'aiovg_admin_notice_dismissed',
	'aiovg_version'
);

foreach ( $aiovg_settings as $settings ) {
	delete_option( $settings );
}

// Delete capabilities
$roles = new AIOVG_Roles;
$roles->remove_caps();
