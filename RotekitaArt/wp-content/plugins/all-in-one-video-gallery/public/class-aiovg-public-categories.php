<?php

/**
 * Categories
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
 * AIOVG_Public_Categories class.
 *
 * @since    1.0.0
 */
class AIOVG_Public_Categories {

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
		add_shortcode( "aiovg_categories", array( $this, "run_shortcode_categories" ) );		

	}
	
	/**
	 * Run the shortcode [aiovg_categories].
	 *
	 * @since    1.0.0
	 * @param    array    $atts    An associative array of attributes.
	 */
	public function run_shortcode_categories( $atts ) {
	
		// Vars
		$attributes = shortcode_atts( $this->get_defaults(), $atts );	
		$attributes['ratio'] = ! empty( $attributes['ratio'] ) ? (float) $attributes['ratio'] . '%' : '56.25%';
		
		// Enqueue style dependencies
		wp_enqueue_style( AIOVG_PLUGIN_SLUG );
		
		// Define the query
		$args = array(
			'parent'       => (int) $attributes['id'],
			'orderby'      => sanitize_text_field( $attributes['orderby'] ), 
    		'order'        => sanitize_text_field( $attributes['order'] ),
    		'hide_empty'   => (int) $attributes['hide_empty'],
			'hierarchical' => false
  		);
		
		$terms = get_terms( 'aiovg_categories', $args );
		
		// Process output
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			
			ob_start();
			include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . "public/templates/categories-grid.php" );
			return ob_get_clean();
		
		}
		
		return aiovg_get_message( 'empty' );
	
	}
	
	/**
	 * Filters the [aiovg_category] shortcode output.
	 *
	 * @since     1.0.0
	 * @param     string    $output    The output from the [aiovg_category] shortcode.
	 * @param     string    $tag       The name of the shortcode.
	 * @return    string    $output    The modified output.
	 */
	public function do_shortcode_tag( $output, $tag ) {
	
		if ( 'aiovg_category' !== $tag ) {
			return $output;
		}
	
		global $post;

		if ( ! isset( $post ) ) {
			return $output;
		}
		
		$page_settings = get_option( 'aiovg_page_settings' );
		
		if ( $post->ID == $page_settings['category'] ) {
		
			if ( $term_slug = get_query_var( 'aiovg_category' ) ) {
			
				$term = get_term_by( 'slug', $term_slug, 'aiovg_categories' );
				$term_id = $term->term_id;
				
				$empty_message = aiovg_get_message( 'empty' );
					
				$description = '';			
				if ( ! empty( $term->description ) ) {
					$description = sprintf( '<p>%s</p>', nl2br( $term->description ) );
				}
				
				if ( $output == $empty_message ) {
					$output = '';
				}				
				
				$attributes = array( 'id="' . $term->term_id . '"' );
				if ( ! empty( $output ) ) {
					$attributes[] = 'title="' . __( 'Sub Categories', 'all-in-one-video-gallery' ) . '"';
				}
				
				$sub_categories = do_shortcode( '[aiovg_categories ' . implode( ' ', $attributes ) . ']' );				
				if ( $sub_categories == $empty_message ) {
					$sub_categories = '';
				}
				
				$output = $description . $output . $sub_categories;
				if ( empty( $output ) ) {
					$output = $empty_message;
				}
				
			}
			
		}
		
		return $output;
					
	}
	
	/**
	 * Get the default shortcode attribute values.
	 *
	 * @since     1.0.0
	 * @return    array    $atts    An associative array of attributes.
	 */
	public function get_defaults() {
	
		if ( empty( $this->defaults ) ) {
		
			$image_settings      = get_option( 'aiovg_image_settings' );
			$categories_settings = get_option( 'aiovg_categories_settings' );
			
			$this->defaults = array(
				'title'            => '',
				'id'               => 0,
				'ratio'            => $image_settings['ratio'],
				'columns'          => $categories_settings['columns'],
				'orderby'          => $categories_settings['orderby'],
				'order'            => $categories_settings['order'],
				'show_description' => $categories_settings['show_description'],
				'show_count'       => $categories_settings['show_count'],
				'hide_empty'       => $categories_settings['hide_empty']		
			);
		
		}
		
		return $this->defaults;
		
	}
	
}
