<?php

/**
 * Videos
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/public
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG_Public_Videos class.
 *
 * @since    1.0.0
 */
class AIOVG_Public_Videos {

	/**
	 * The detault shortcode attribute values.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       array        $defaults    An associative array of defaults.
	 */
	protected $defaults;
	
	/**
	 * Get things going.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Register shortcode(s)
		add_shortcode( "aiovg_videos", array( $this, "run_shortcode_videos" ) );
		add_shortcode( "aiovg_category", array( $this, "run_shortcode_category" ) );
		add_shortcode( "aiovg_search", array( $this, "run_shortcode_search" ) );
		add_shortcode( "aiovg_user_videos", array( $this, "run_shortcode_user_videos" ) );

	}

	/**
	 * Run the shortcode [aiovg_videos].
	 *
	 * @since    1.0.0
	 * @param    array    $atts    An associative array of attributes.
	 */
	public function run_shortcode_videos( $atts ) {
		
		$attributes = shortcode_atts( $this->get_defaults(), $atts );
				
		$content = $this->get_content( $attributes );
		
		if ( empty( $content ) ) {
			$content = aiovg_get_message( 'empty' );
		}
		
		return $content;
		
	}
	
	/**
	 * Run the shortcode [aiovg_category].
	 *
	 * @since    1.0.0
	 * @param    array    $atts    An associative array of attributes.
	 */
	public function run_shortcode_category( $atts ) {
	
		$term_slug = get_query_var( 'aiovg_category' );
		$term_id   = 0;
		$content   = '';
		
		if ( ! empty( $term_slug ) ) {
			$term = get_term_by( 'slug', $term_slug, 'aiovg_categories' );
        	$term_id = $term->term_id;
		} elseif ( ! empty( $atts['id'] ) ) {		
        	$term_id = $atts['id'];		
		}
		
		if ( ! empty( $term_id ) ) {
		
			$attributes = shortcode_atts( $this->get_defaults(), $atts );
			$attributes['category'] = $term_id;			

			$content = $this->get_content( $attributes );
		
		}
		
		if ( empty( $content ) ) {
			$content = aiovg_get_message( 'empty' );
		}
		
		return $content;
	
	}
	
	/**
	 * Run the shortcode [aiovg_search].
	 *
	 * @since    1.0.0
	 * @param    array    $atts    An associative array of attributes.
	 */
	public function run_shortcode_search( $atts ) {
	
		$attributes = shortcode_atts( $this->get_defaults(), $atts );
		
		if( isset( $_GET['vi'] ) ) {
			$attributes['search_query'] = $_GET['vi'];
		}
		
		if( isset( $_GET['ca'] ) ) {
			$attributes['category'] = $_GET['ca'];
		}
		
		$content = $this->get_content( $attributes );
		
		if ( empty( $content ) ) {
			$content = aiovg_get_message( 'empty' );
		}
		
		return $content;
		
	}
	
	/**
	 * Run the shortcode [aiovg_user_videos].
	 *
	 * @since    1.0.0
	 * @param    array    $atts    An associative array of attributes.
	 */
	public function run_shortcode_user_videos( $atts ) {
	
		$user_slug = get_query_var( 'aiovg_user' );
		$content   = '';		
		
		if ( empty( $user_slug ) ) {
			if ( ! empty( $atts['id'] ) ) {
				$user_slug = get_the_author_meta( 'user_nicename', (int) $atts['id'] );	
			} elseif ( is_user_logged_in() ) {
				$user_slug = get_the_author_meta( 'user_nicename', get_current_user_id() );				
			}
		}
		
		if ( ! empty( $user_slug ) ) {
		
			$attributes = shortcode_atts( $this->get_defaults(), $atts );
			$attributes['user_slug'] = $user_slug;

			$content = $this->get_content( $attributes );
		
		}
		
		if ( empty( $content ) ) {
			$content = aiovg_get_message( 'empty' );
		}
		
		return $content;
	
	}
	
	/**
	 * Get the html output.
	 *
	 * @since     1.0.0
	 * @param     array     $atts       An associative array of attributes.
	 * @return    string    $content    HTML output.
	 */
	public function get_content( $attributes ) {
		
		$attributes['ratio'] = ! empty( $attributes['ratio'] ) ? (int) $attributes['ratio'] . '%' : '56.25%';
		
		// Enqueue style dependencies
		wp_enqueue_style( AIOVG_PLUGIN_SLUG );
		
		// Define the query
		$args = array(				
			'post_type'      => 'aiovg_videos',
			'post_status'    => 'publish',
			'posts_per_page' => (int) $attributes['limit'],
			'paged'          => (int) $attributes['paged']
		);
		
		if ( ! empty( $attributes['search_query'] ) ) { // Search
			$args['s'] = sanitize_text_field( $attributes['search_query'] );
		}
		
		if ( ! empty( $attributes['category'] ) ) { // Category
			$args['tax_query'] = array(
				array(
					'taxonomy'         => 'aiovg_categories',
					'field'            => 'term_id',
					'terms'            => array_map( 'intval', explode( ',', $attributes['category'] ) ),
					'include_children' => false
				)
			);
		}
		
		if( ! empty( $attributes['featured'] ) ) { // Featured			
			$args['meta_query'] = array(
				array(
					'key'     => 'featured',
					'value'   => 1,
					'compare' => '='
				)
			);				
		}
		
		if ( ! empty( $attributes['user_slug'] ) ) { // User
			$args['author_name'] = sanitize_text_field( $attributes['user_slug'] );
		}		
		
		if ( ! empty( $attributes['exclude'] ) ) { // Exclude video IDs
			$args['post__not_in'] = array_map( 'intval', explode( ',', $attributes['exclude'] ) );
		}
		
		$orderby = sanitize_text_field( $attributes['orderby'] );
		$order   = sanitize_text_field( $attributes['order'] );
		
		switch ( $orderby ) {
			case 'views':
				$args['meta_key'] = $orderby;
				$args['orderby']  = 'meta_value_num';
			
				$args['order']    = $order;
				break;
			case 'rand':
				$args['orderby']  = $orderby;
				break;
			default:
				$args['orderby']  = $orderby;
				$args['order']    = $order;
		}
	
		$aiovg_query = new WP_Query( $args );
		
		// Start the loop
		global $post;
		
		// Process output
		$content = '';
		
		if ( $aiovg_query->have_posts() ) {
		
			if ( ( is_front_page() && is_home() ) || empty( $attributes['show_pagination'] ) ) {
				$attributes['count'] = $aiovg_query->post_count;
			} else {
				$attributes['count'] = $aiovg_query->found_posts;
			}
			
			ob_start();
			include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . 'public/templates/videos-grid.php' );
			$content = ob_get_clean();
			
		}
		
		return $content;
	
	}
	
	/**
	 * Get the default shortcode attribute values.
	 *
	 * @since     1.0.0
	 * @return    array    $atts    An associative array of attributes.
	 */
	public function get_defaults() {
	
		if ( empty( $this->defaults ) ) {
		
			$image_settings  = get_option( 'aiovg_image_settings' );
			$videos_settings = get_option( 'aiovg_videos_settings' );
			
			$this->defaults = array(							
				'title'           => '',
				'ratio'           => $image_settings['ratio'],				
				'columns'         => $videos_settings['columns'],
				'limit'           => ! empty( $videos_settings['limit'] ) ? $videos_settings['limit'] : -1,
				'category'        => '',
				'exclude'         => '',
				'featured'        => 0,
				'orderby'         => $videos_settings['orderby'],
				'order'           => $videos_settings['order'],
				'show_count'      => isset( $videos_settings['display']['count'] ),
				'count'           => 0,
				'show_category'   => isset( $videos_settings['display']['category'] ),
				'show_date'       => isset( $videos_settings['display']['date'] ),
				'show_user'       => isset( $videos_settings['display']['user'] ),
				'show_views'      => isset( $videos_settings['display']['views'] ),
				'show_duration'   => isset( $videos_settings['display']['duration'] ),
				'show_excerpt'    => isset( $videos_settings['display']['excerpt'] ),
				'excerpt_length'  => $videos_settings['excerpt_length'],
				'show_pagination' => 1,
				'paged'           => aiovg_get_page_number()
			);
		
		}
		
		return $this->defaults;
		
	}
	
}
