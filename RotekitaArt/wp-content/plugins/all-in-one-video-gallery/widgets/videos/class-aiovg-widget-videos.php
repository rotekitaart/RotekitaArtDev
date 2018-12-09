<?php

/**
 * Videos Widget.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/widgets/videos
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG_Widget_Videos class.
 *
 * @since    1.0.0
 */
class AIOVG_Widget_Videos extends WP_Widget {
	
	/**
     * Unique identifier for the widget.
     *
     * @since     1.0.0
	 * @access    protected
     * @var       string
     */
    protected $widget_slug;
	
	/**
     * Default settings.
     *
     * @since     1.0.0
	 * @access    private
     * @var       array
     */
    private $defaults;
	
	/**
	 * Get things going.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		$this->widget_slug = 'aiovg-widget-videos';
		
		$image_settings  = get_option( 'aiovg_image_settings' );
		$videos_settings = get_option( 'aiovg_videos_settings' );
		
		$this->defaults = array(
			'title'          => __( 'Video Gallery', 'all-in-one-video-gallery' ),
			'category'       => array(),		
			'image_position' => 'left',	
			'ratio'          => $image_settings['ratio'],
			'columns'        => 1,
			'limit'          => ! empty( $videos_settings['limit'] ) ? $videos_settings['limit'] : -1,
			'orderby'        => $videos_settings['orderby'],
			'order'          => $videos_settings['order'],
			'featured'       => 0,
			'related'        => 0,			
			'show_category'  => isset( $videos_settings['display']['category'] ),
			'show_date'      => isset( $videos_settings['display']['date'] ),
			'show_user'      => isset( $videos_settings['display']['user'] ),
			'show_views'     => 0,
			'show_duration'  => isset( $videos_settings['display']['duration'] ),
			'show_excerpt'   => 0,
			'excerpt_length' => $videos_settings['excerpt_length'],
			'show_more'      => 0,
			'more_label'     => __( 'Show More', 'all-in-one-video-gallery' ),
			'more_link'      => ''
		);
		
		$this->defaults['ratio'] = ! empty( $this->defaults['ratio'] ) ? (float) $this->defaults['ratio'] . '%' : '56.25%';
		
		parent::__construct(
			$this->widget_slug,
			__( 'AIOVG - Video Gallery', 'all-in-one-video-gallery' ),
			array(
				'classname'   => $this->widget_slug,
				'description' => __( 'Displays a video gallery.', 'all-in-one-video-gallery' )
			)
		);
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ), 11 );
	
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since    1.0.0
	 * @param    array	  $args	       The array of form elements.
	 * @param	 array    $instance    The current instance of the widget.
	 */
	public function widget( $args, $instance ) {
		
		// Merge incoming $instance array with $defaults
		if ( count( $instance ) ) {
			$attributes = array_merge( $this->defaults, $instance );
		} else {
			$attributes = $this->defaults;
		}
		
		if ( empty( $attributes['more_label'] ) || empty( $attributes['more_link'] ) ) {
			$attributes['show_more'] = 0;
		}
		
		// Define the query
		global $post;
		
		$query = array(				
			'post_type'      => 'aiovg_videos',
			'post_status'    => 'publish',
			'posts_per_page' => ! empty( $attributes['limit'] ) ? (int) $attributes['limit'] : -1
		);
		
		$tax_queries  = array();
		$meta_queries = array();
		
		$category = array_map( 'intval', $attributes['category'] );
	
		if ( $attributes['related'] ) {
		
			if ( is_singular( 'aiovg_videos' ) ) {
			
				$categories = wp_get_object_terms( $post->ID, 'aiovg_categories', array( 'fields' => 'ids' ) );
				$category = ! empty( $categories ) ? $categories : '';
				
				$query['post__not_in'] = array( $post->ID );

			} else {
			
				$term_slug = get_query_var( 'aiovg_category' );				
				if ( ! empty( $term_slug ) ) {		
					$term = get_term_by( 'slug', sanitize_text_field( $term_slug ), 'aiovg_categories' );
					$category = $term->term_id;
				}
			
			}
			
		}
		
		if ( ! empty( $category ) ) {		
			$tax_queries[] = array(
				'taxonomy'         => 'aiovg_categories',
				'field'            => 'term_id',
				'terms'            => $category,
				'include_children' => false,
			);					
		}		

		if( ! empty( $attributes['featured'] ) ) {			
			$meta_queries[] = array(
				'key'     => 'featured',
				'value'   => 1,
				'compare' => '='
			);				
		}
		
		$count_tax_queries = count( $tax_queries );
		if( $count_tax_queries ) {
			$query['tax_query'] = ( $count_tax_queries > 1 ) ? array_merge( array( 'relation' => 'AND' ), $tax_queries ) : array( $tax_queries );
		}
	
		$count_meta_queries = count( $meta_queries );
		if( $count_meta_queries ) {
			$query['meta_query'] = ( $count_meta_queries > 1 ) ? array_merge( array( 'relation' => 'AND' ), $meta_queries ) : array( $meta_queries );
		}
		
		$orderby = sanitize_text_field( $attributes['orderby'] );
		$order   = sanitize_text_field( $attributes['order'] );
	
		switch ( $orderby ) {
			case 'views':
				$query['meta_key'] = $orderby;
				$query['orderby']  = 'meta_value_num';
				
				$query['order']    = $order;
				break;
			case 'rand':
				$query['orderby'] = $orderby;
				break;
			default:
				$query['orderby'] = $orderby;
				$query['order']   = $order;
		}
		
		$aiovg_query = new WP_Query( $query );
		
		// Process output
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		if ( $aiovg_query->have_posts() ) {
		
			if ( 'left' == $attributes['image_position'] ) {
				include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . 'widgets/videos/templates/videos-grid-image-left.php' );
			} else {
				include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . 'widgets/videos/templates/videos-grid-image-top.php' );
			}
			
		} else {
		
			echo aiovg_get_message( 'empty' );
		
		}
		
		echo $args['after_widget'];

	}
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @since    1.0.0
	 * @param	 array	  $new_instance    The new instance of values to be generated via the update.
	 * @param	 array    $old_instance    The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		
		$instance['title']          = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['category']       = isset( $new_instance['category'] ) ? array_map( 'intval', $new_instance['category'] ) : array();
		$instance['image_position'] = isset( $new_instance['image_position'] ) ? sanitize_text_field( $new_instance['image_position'] ) : 'left';
		$instance['columns']        = isset( $new_instance['columns'] ) ? (int) $new_instance['columns'] : 1;
		$instance['limit']          = isset( $new_instance['limit'] ) ? (int) $new_instance['limit'] : 0;
		$instance['orderby']        = isset( $new_instance['orderby'] ) ? sanitize_text_field( $new_instance['orderby'] ) : 'title';
		$instance['order']          = isset( $new_instance['order'] ) ? sanitize_text_field( $new_instance['order'] ) : 'asc';
		$instance['featured']       = isset( $new_instance['featured'] ) ? 1 : 0;
		$instance['related']        = isset( $new_instance['related'] ) ? 1 : 0;
		$instance['show_category']  = isset( $new_instance['show_category'] ) ? 1 : 0;	
		$instance['show_date']      = isset( $new_instance['show_date'] ) ? 1 : 0;	
		$instance['show_user']      = isset( $new_instance['show_user'] ) ? 1 : 0;
		$instance['show_views']     = isset( $new_instance['show_views'] ) ? 1 : 0;
		$instance['show_duration']  = isset( $new_instance['show_duration'] ) ? 1 : 0;
		$instance['show_excerpt']   = isset( $new_instance['show_excerpt'] ) ? 1 : 0;	
		$instance['show_more']      = isset( $new_instance['show_more'] ) ? 1 : 0;
		$instance['more_label']     = isset( $new_instance['more_label'] ) ? sanitize_text_field( $new_instance['more_label'] ) : '';	
		$instance['more_link']      = isset( $new_instance['more_link'] ) ? sanitize_url( $new_instance['more_link'] ) : '';	
		
		return $instance;

	}
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @since    1.0.0
	 * @param	 array    $instance    The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		// Parse incoming $instance into an array and merge it with $defaults
		$instance = wp_parse_args(
			(array) $instance,
			$this->defaults
		);		
			
		// Display the admin form
		include AIOVG_PLUGIN_DIR . 'widgets/videos/templates/admin.php';

	}
	
	/**
	 * Enqueues widget-specific styles & scripts.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles_scripts() {		
	
		if ( is_active_widget( false, $this->id, $this->id_base, true ) ) {
			wp_enqueue_style( AIOVG_PLUGIN_SLUG );
		}

	}
	
}