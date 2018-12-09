<?php

/**
 * Shortcode Builder.
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
 * AIOVG_Admin_Shortcode class.
 *
 * @since    1.0.0
 */
class AIOVG_Admin_Shortcode {
	
	/**
	 * Adds an "Video Player & Gallery" button above the TinyMCE Editor on add/edit screens.
	 *
	 * @since    1.0.0
	 */
	public function media_buttons() {

		global $pagenow, $typenow;
		
		// Only run in post/page creation and edit screens
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) && 'aiovg_videos' != $typenow ) {
			printf( '<a href="#aiovg-shortcode-builder" class="button button-primary aiovg-media-button" id="aiovg-media-button"><span class="wp-media-buttons-icon dashicons dashicons-playlist-video"></span> %s</a>', __( 'Video Player & Gallery', 'all-in-one-video-gallery' ) );
		}

	}
	
	/**
	 * Prints the footer code needed for the "AIO Video Gallery" TinyMCE button.
	 *
	 * @since    1.0.0
	 */
	public function admin_footer() {

		global $pagenow, $typenow;
		
		// Only run in post/page creation and edit screens
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) && 'aiovg_videos' != $typenow ) {
		
			$categories_settings = get_option( 'aiovg_categories_settings' );
			$videos_settings     = get_option( 'aiovg_videos_settings' );
			$player_settings      = get_option( 'aiovg_player_settings' );
			
			// Videos
			$items = get_posts( array(
				'post_type'   => 'aiovg_videos',
				'post_status' => 'publish',
				'numberposts' => -1
			) );
			
			$videos = array(
				0 => '-- ' . __( 'Latest Video', 'all-in-one-video-gallery' ) . ' --'
			);
			
			foreach ( $items as $item ) {
				$videos[ $item->ID ] = $item->post_title;
			}
			
			// Shortcodes
			$shortcodes = array(				
				'categories'  => __( 'Video Categories', 'all-in-one-video-gallery' ) . ' - [aiovg_categories]',
				'videos'      => __( 'Video Gallery', 'all-in-one-video-gallery' ) . ' - [aiovg_videos]',
				'video'       => __( 'Single Video', 'all-in-one-video-gallery' ) . ' - [aiovg_video]',
				'search_form' => __( 'Search Form', 'all-in-one-video-gallery' ) . ' - [aiovg_search_form]'			
			);
			$shortcodes = apply_filters( 'aiovg_shortcode_types', $shortcodes );
			
			// Fields
			$fields = array(
				'categories' => array(
					array(
						'name'    => 'id',
						'label'   => __( 'Select Parent', 'all-in-one-video-gallery' ),
						'type'    => 'category',
						'options' => array(),
						'value'   => 0,
						'default' => 0
					),
					array(
						'name'    => 'columns',
						'label'   => __( 'Number of Columns', 'all-in-one-video-gallery' ),
						'type'    => 'text',
						'value'   => $categories_settings['columns'],
						'default' => $categories_settings['columns']
					),
					array(
						'name'    => 'orderby',
						'label'   => __( 'Sort Categories by', 'all-in-one-video-gallery' ),
						'type'    => 'select',
						'options' => array(
							'id'    => __( 'ID', 'all-in-one-video-gallery' ),
							'count' => __( 'Count', 'all-in-one-video-gallery' ),
							'name'  => __( 'Name', 'all-in-one-video-gallery' ),
							'slug'  => __( 'Slug', 'all-in-one-video-gallery' )	
						),
						'value'   => $categories_settings['orderby'],
						'default' => $categories_settings['orderby']
					),
					array(
						'name'    => 'order',
						'label'   => __( 'Order Categories by', 'all-in-one-video-gallery' ),
						'type'    => 'select',
						'options' => array(
							'asc'  => __( 'ASC', 'all-in-one-video-gallery' ),
							'desc' => __( 'DESC', 'all-in-one-video-gallery' )
						),
						'value'   => $categories_settings['order'],
						'default' => $categories_settings['order']
					),
					array(
						'name'    => 'show_description',
						'label'   => __( 'Show Description?', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => $categories_settings['show_description'],
						'default' => $categories_settings['show_description']
					),
					array(
						'name'    => 'show_count',
						'label'   => __( 'Show Videos Count?', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => $categories_settings['show_count'],
						'default' => $categories_settings['show_count']
					),
					array(
						'name'    => 'hide_empty',
						'label'   => __( 'Hide Empty Categories?', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => $categories_settings['hide_empty'],
						'default' => $categories_settings['hide_empty']
					)
				),
				'videos' => array(
					array(
						'name'    => 'category',
						'label'   => __( 'Select Categories', 'all-in-one-video-gallery' ),
						'type'    => 'categories',
						'options' => array(),
						'value'   => 0,
						'default' => 0
					),		
					array(
						'name'    => 'columns',
						'label'   => __( 'Number of Columns', 'all-in-one-video-gallery' ),
						'type'    => 'text',
						'value'   => $videos_settings['columns'],
						'default' => $videos_settings['columns']
					),
					array(
						'name'    => 'limit',
						'label'   => __( 'Limit', 'all-in-one-video-gallery' ),
						'type'    => 'text',
						'value'   => $videos_settings['limit'],
						'default' => $videos_settings['limit']
					),
					array(
						'name'    => 'orderby',
						'label'   => __( 'Order By', 'all-in-one-video-gallery' ),
						'type'    => 'select',
						'options' => array(
							'title' => __( 'Title', 'all-in-one-video-gallery' ),
							'date'  => __( 'Date Posted', 'all-in-one-video-gallery' ),
							'views' => __( 'Views Count', 'all-in-one-video-gallery' ),
							'rand'  => __( 'Random', 'all-in-one-video-gallery' )
						),
						'value'   => $videos_settings['orderby'],
						'default' => $videos_settings['orderby']
					),
					array(
						'name'    => 'order',
						'label'   => __( 'Order', 'all-in-one-video-gallery' ),
						'type'    => 'select',
						'options' => array(
							'asc'  => __( 'ASC', 'all-in-one-video-gallery' ),
							'desc' => __( 'DESC', 'all-in-one-video-gallery' )
						),
						'value'   => $videos_settings['order'],
						'default' => $videos_settings['order']
					),
					array(
						'name'    => 'featured',
						'label'   => __( 'Featured Only', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => 0,
						'default' => 0
					),
					array(
						'name'    => 'related',
						'label'   => sprintf( "%s ( %s )", __( 'Follow URL?', 'all-in-one-video-gallery' ), __( 'Related Videos', 'all-in-one-video-gallery' ) ),
						'type'    => 'checkbox',
						'value'   => 0,
						'default' => 0
					),
					array(
						'name'    => 'html',
						'label'   => __( 'Show / Hide', 'all-in-one-video-gallery' ),
						'type'    => 'html'
					),
					array(
						'name'    => 'show_count',
						'label'   => __( 'Videos Count', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => 0,
						'default' => isset( $videos_settings['display']['count'] )
					),
					array(
						'name'    => 'show_category',
						'label'   => __( 'Category Name', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $videos_settings['display']['category'] ),
						'default' => isset( $videos_settings['display']['category'] )
					),
					array(
						'name'    => 'show_date',
						'label'   => __( 'Date Added', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $videos_settings['display']['date'] ),
						'default' => isset( $videos_settings['display']['date'] )
					),
					array(
						'name'    => 'show_user',
						'label'   => __( 'Author Name', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $videos_settings['display']['user'] ),
						'default' => isset( $videos_settings['display']['user'] )
					),
					array(
						'name'    => 'show_views',
						'label'   => __( 'Views Count', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $videos_settings['display']['views'] ),
						'default' => isset( $videos_settings['display']['views'] )
					),
					array(
						'name'    => 'show_duration',
						'label'   => __( 'Video Duration', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $videos_settings['display']['duration'] ),
						'default' => isset( $videos_settings['display']['duration'] )
					),
					array(
						'name'    => 'show_excerpt',
						'label'   => __( 'Excerpt ( Short Description )', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $videos_settings['display']['excerpt'] ),
						'default' => isset( $videos_settings['display']['excerpt'] )
					),
					array(
						'name'    => 'show_pagination',
						'label'   => __( 'Show Pagination', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => 1,
						'default' => 1
					)
				),
				'video' => array(
					array(
						'name'    => 'id',
						'label'   => __( 'Select a Video', 'all-in-one-video-gallery' ),
						'type'    => 'select',
						'options' => $videos,
						'value'   => 0,
						'default' => 0
					),
					array(
						'name'    => 'width',
						'label'   => __( 'Width', 'all-in-one-video-gallery' ),
						'type'    => 'text',
						'value'   => '',
						'default' => ''
					),
					array(
						'name'    => 'ratio',
						'label'   => __( 'Ratio', 'all-in-one-video-gallery' ),
						'type'    => 'text',
						'value'   => $player_settings['ratio'],
						'default' => $player_settings['ratio']
					),
					array(
						'name'    => 'autoplay',
						'label'   => __( 'Autoplay', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => $player_settings['autoplay'],
						'default' => $player_settings['autoplay']
					),
					array(
						'name'    => 'loop',
						'label'   => __( 'Loop', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => $player_settings['loop'],
						'default' => $player_settings['loop']
					),
					array(
						'name'    => 'html',
						'label'   => __( 'Show / Hide Player Controls', 'all-in-one-video-gallery' ),
						'type'    => 'html'
					),
					array(
						'name'    => 'playpause',
						'label'   => __( 'Play / Pause', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $player_settings['controls']['playpause'] ),
						'default' => isset( $player_settings['controls']['playpause'] )
					),
					array(
						'name'    => 'current',
						'label'   => __( 'Current Time', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $player_settings['controls']['current'] ),
						'default' => isset( $player_settings['controls']['current'] )
					),
					array(
						'name'    => 'progress',
						'label'   => __( 'Progressbar', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $player_settings['controls']['progress'] ),
						'default' => isset( $player_settings['controls']['progress'] )
					),
					array(
						'name'    => 'duration',
						'label'   => __( 'Duration', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $player_settings['controls']['duration'] ),
						'default' => isset( $player_settings['controls']['duration'] )
					),
					array(
						'name'    => 'tracks',
						'label'   => __( 'Subtitles', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $player_settings['controls']['tracks'] ),
						'default' => isset( $player_settings['controls']['tracks'] )
					),
					array(
						'name'    => 'volume',
						'label'   => __( 'Volume', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $player_settings['controls']['volume'] ),
						'default' => isset( $player_settings['controls']['volume'] )
					),
					array(
						'name'    => 'fullscreen',
						'label'   => __( 'Fullscreen', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => isset( $player_settings['controls']['fullscreen'] ),
						'default' => isset( $player_settings['controls']['fullscreen'] )
					)
				),
				'search_form' => array(
					array(
						'name'    => 'template',
						'label'   => __( 'Select a Template', 'all-in-one-video-gallery' ),
						'type'    => 'select',
						'options' => array(
							'vertical'   => __( 'Vertical', 'all-in-one-video-gallery' ),
							'horizontal' => __( 'Horizontal', 'all-in-one-video-gallery' )
						),
						'value'   => 'horizontal',
						'default' => 'horizontal'
					),
					array(
						'name'    => 'category',
						'label'   => __( 'Search by Categories', 'all-in-one-video-gallery' ),
						'type'    => 'checkbox',
						'value'   => 0,
						'default' => 0
					)
				)
			);			
			$fields = apply_filters( 'aiovg_shortcode_fields', $fields );
			
			// ...
			require_once AIOVG_PLUGIN_DIR . 'admin/templates/shortcode-builder.php';
		}

	}

}