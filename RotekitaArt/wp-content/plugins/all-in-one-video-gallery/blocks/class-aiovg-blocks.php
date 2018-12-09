<?php

/**
 * Blocks Initializer.
 *
 * @link          https://plugins360.com
 * @since         1.5.6
 *
 * @package       AIOVG
 * @subpackage    AIOVG/blocks
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG_Blocks class.
 *
 * @since    1.5.6
 */
class AIOVG_Blocks {

	/**
	 * Register our custom Gutenberg block category.
	 *
	 * @since     1.5.6
	 * @param     array    $categories    Default Gutenberg block categories.
	 * @return    array                   Modified Gutenberg block categories.
	 */
	public function block_categories( $categories ) {
		
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'all-in-one-video-gallery',
					'title' => __( 'All-in-One Video Gallery', 'all-in-one-video-gallery' ),
				),
			)
		);
		
	}

	/**
	 * Enqueue Gutenberg block assets for backend editor.
	 *
	 * @since    1.5.6
	 */
	public function enqueue_block_editor_assets() {

		$categories_settings = get_option( 'aiovg_categories_settings' );
		$videos_settings     = get_option( 'aiovg_videos_settings' );
		$player_settings     = get_option( 'aiovg_player_settings' );

		// Scripts
		wp_enqueue_script(
			'aiovg-guten-blocks-js',
			plugins_url( '/blocks/dist/blocks.build.js', dirname( __FILE__ ) ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			filemtime( plugin_dir_path( __DIR__ ) . 'blocks/dist/blocks.build.js' ),
			true
		);

		wp_localize_script( 
			'aiovg-guten-blocks-js', 
			'aiovg', 
			array(
				'categories' => array(
					'columns'          => $categories_settings['columns'],
					'orderby'          => $categories_settings['orderby'],
					'order'            => $categories_settings['order'],
					'show_description' => $categories_settings['show_description'],
					'show_count'       => $categories_settings['show_count'],
					'hide_empty'       => $categories_settings['hide_empty']
				),
				'videos' => array(
					'category'         => 0,
					'columns'          => $videos_settings['columns'],
					'limit'            => $videos_settings['limit'],
					'orderby'          => $videos_settings['orderby'],
					'order'            => $videos_settings['order'],
					'featured'         => false,
					'related'          => false,
					'show_count'       => isset( $videos_settings['display']['count'] ),
					'show_category'    => isset( $videos_settings['display']['category'] ),
					'show_date'        => isset( $videos_settings['display']['date'] ),
					'show_user'        => isset( $videos_settings['display']['user'] ),
					'show_views'       => isset( $videos_settings['display']['views'] ),
					'show_duration'    => isset( $videos_settings['display']['duration'] ),
					'show_excerpt'     => isset( $videos_settings['display']['excerpt'] ),
					'show_pagination'  => true
				),
				'search' => array(
					'template'         => 'horizontal',
					'category'         => false
				),
				'video'	 => array(
					'src'              => '',
					'poster'           => '',
					'width'            => 0,
					'ratio'            => $player_settings['ratio'],
					'autoplay'         => $player_settings['autoplay'] ? true : false,
					'loop'             => $player_settings['loop'] ? true : false,
					'playpause'        => isset( $player_settings['controls']['playpause'] ),
					'current'          => isset( $player_settings['controls']['current'] ),
					'progress'         => isset( $player_settings['controls']['progress'] ),
					'duration'         => isset( $player_settings['controls']['duration'] ),					
					'volume'           => isset( $player_settings['controls']['volume'] ),
					'fullscreen'       => isset( $player_settings['controls']['fullscreen'] )
				)
			)
		);

		// Styles
		wp_enqueue_style( 
			AIOVG_PLUGIN_SLUG . '-bootstrap', 
			AIOVG_PLUGIN_URL . 'public/assets/css/bootstrap.css', 
			array(), 
			'3.3.7'
		);

		wp_enqueue_style( 
			AIOVG_PLUGIN_SLUG . '-fontawesome', 
			AIOVG_PLUGIN_URL . 'public/assets/css/font-awesome.min.css', 
			array(), 
			'4.7.0'
		);

		wp_enqueue_style( 
			AIOVG_PLUGIN_SLUG . '-public', 
			AIOVG_PLUGIN_URL . 'public/assets/css/aiovg-public.css', 
			array(), 
			AIOVG_PLUGIN_VERSION
		);

	}	

	/**
	 * Register our custom blocks.
	 * 
	 * @since    1.5.6
	 */
	public function register_block_types() {

		// Hook the post rendering to the block
		if ( function_exists( 'register_block_type' ) ) {

			// Hook a render function to the categories block
			register_block_type( 'aiovg/categories', array(
				'attributes' => array(
					'id' => array(
						'type' => 'number'
					),
					'columns' => array(
						'type' => 'number'
					),
					'orderby' => array(
						'type' => 'string'
					),
					'order' => array(
						'type' => 'string'
					),
					'show_description' => array(
						'type' => 'boolean'
					),
					'show_count' => array(
						'type' => 'boolean'
					),
					'hide_empty' => array(
						'type' => 'boolean'
					)
				),
				'render_callback' => array( $this, 'render_categories_block' ),
			) );

			// Hook a render function to the videos block
			register_block_type( 'aiovg/videos', array(
				'attributes' => array(
					'category' => array(
						'type' => 'array'
					),
					'columns' => array(
						'type' => 'number'
					),
					'limit' => array(
						'type' => 'number'
					),
					'orderby' => array(
						'type' => 'string'
					),
					'order' => array(
						'type' => 'string'
					),
					'featured' => array(
						'type' => 'boolean'
					),
					'related' => array(
						'type' => 'boolean'
					),
					'show_count' => array(
						'type' => 'boolean'
					),
					'show_category' => array(
						'type' => 'boolean'
					),
					'show_date' => array(
						'type' => 'boolean'
					),
					'show_user' => array(
						'type' => 'boolean'
					),
					'show_views' => array(
						'type' => 'boolean'
					),
					'show_duration' => array(
						'type' => 'boolean'
					),
					'show_excerpt' => array(
						'type' => 'boolean'
					),
					'show_pagination' => array(
						'type' => 'boolean'
					)
				),
				'render_callback' => array( $this, 'render_videos_block' ),
			) );

			// Hook a render function to the search block
			register_block_type( 'aiovg/search', array(
				'attributes' => array(
					'template' => array(
						'type' => 'string'
					),
					'category' => array(
						'type' => 'boolean'
					)
				),
				'render_callback' => array( $this, 'render_search_block' ),
			) );

			// Hook a render function to the video player block
			register_block_type( 'aiovg/video', array(
				'attributes' => array(
					'src' => array(
						'type' => 'string'
					),
					'poster' => array(
						'type' => 'string'
					),
					'width' => array(
						'type' => 'number'
					),
					'ratio' => array(
						'type' => 'number'
					),
					'autoplay' => array(
						'type' => 'boolean'
					),
					'loop' => array(
						'type' => 'boolean'
					),
					'playpause' => array(
						'type' => 'boolean'
					),
					'current' => array(
						'type' => 'boolean'
					),
					'progress' => array(
						'type' => 'boolean'
					),
					'duration' => array(
						'type' => 'boolean'
					),					
					'volume' => array(
						'type' => 'boolean'
					),
					'fullscreen' => array(
						'type' => 'boolean'
					)
				),
				'render_callback' => array( $this, 'render_video_player_block' ),
			) );

		}

	}

	/**
	 * Render the categories block frontend.
	 *
	 * @since     1.5.6
	 * @param     array     $atts    An associative array of attributes.
	 * @return    string             HTML output.
	 */
	public function render_categories_block( $atts ) {

		if ( ! is_null( $atts['columns'] ) && 0 == (int) $atts['columns'] ) {
			return '';
		}

		return do_shortcode( '[aiovg_categories ' . $this->build_shortcode_attributes( $atts ) . ']' );

	}

	/**
	 * Render the videos block frontend.
	 *
	 * @since     1.5.6
	 * @param     array     $atts    An associative array of attributes.
	 * @return    string             HTML output.
	 */
	public function render_videos_block( $atts ) {
		
		if ( ! is_null( $atts['columns'] ) && 0 == (int) $atts['columns'] ) {
			return '';
		}

		return do_shortcode( '[aiovg_videos ' . $this->build_shortcode_attributes( $atts ) . ']' );

	}

	/**
	 * Render the search block frontend.
	 *
	 * @since     1.5.6
	 * @param     array     $atts    An associative array of attributes.
	 * @return    string             HTML output.
	 */
	public function render_search_block( $atts ) {
		return do_shortcode( '[aiovg_search_form ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Render the video player block frontend.
	 *
	 * @since     1.5.6
	 * @param     array     $atts    An associative array of attributes.
	 * @return    string             HTML output.
	 */
	public function render_video_player_block( $atts ) {

		if ( empty( $atts['src'] ) ) {
			return;
		}		

		if ( false !== strpos( $atts['src'], 'youtube.com' ) ) {

			$atts['youtube'] = $atts['src'];

			if ( empty( $atts['poster'] ) ) {
				$atts['poster'] = aiovg_get_youtube_image_url( $atts['youtube'] );
			}

		} elseif ( false !== strpos( $atts['src'], 'vimeo.com' ) ) {

			$atts['vimeo'] = $atts['src'];

			if ( empty( $atts['poster'] ) ) {
				$atts['poster'] = aiovg_get_vimeo_image_url( $atts['vimeo'] );
			}

		} elseif ( false !== strpos( $atts['src'], 'dailymotion.com' ) ) {

			$atts['dailymotion'] = $atts['src'];

			if ( empty( $atts['poster'] ) ) {
				$atts['poster'] = aiovg_get_dailymotion_image_url( $atts['dailymotion'] );
			}

		} elseif ( false !== strpos( $atts['src'], 'facebook.com' ) ) {

			$atts['facebook'] = $atts['src'];

		} else {

			$filetype = wp_check_filetype( $atts['src'] );

			if ( in_array( $filetype['ext'], array( 'mp4', 'webm', 'ogv' ) ) ) {
				$atts[ $filetype['ext'] ] = $atts['src'];
			} else {
				return;
			}

		}

		unset( $atts['src'] );
		
		foreach ( $atts as $key => $value ) {

			if ( is_null( $value ) ) {
				unset( $atts[ $key ] );
			}

		}

		$post_id = 0;

		return aiovg_get_player_html( $post_id, $atts );

	}

	/**
	 * Build shortcode attributes string.
	 * 
	 * @since     1.5.6
	 * @access    private
	 * @param     array      $atts    Array of attributes.
	 * @return    string              Shortcode attributes string.
	 */
	private function build_shortcode_attributes( $atts ) {

		$attributes = array();
		
		foreach ( $atts as $key => $value ) {

			if ( is_null( $value ) ) {
				continue;
			}

			if ( empty( $value ) ) {
				$value = 0;
			}

			if ( is_array( $value ) ) {
				$value = implode( ',', $value );
			}

			$attributes[] = sprintf( '%s="%s"', $key, $value );

		}
		
		return implode( ' ', $attributes );

	}

}