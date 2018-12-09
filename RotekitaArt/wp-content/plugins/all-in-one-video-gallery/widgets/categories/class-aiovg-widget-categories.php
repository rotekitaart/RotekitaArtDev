<?php

/**
 * Categories Widget.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/widgets/categories
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG_Widget_Categories class.
 *
 * @since    1.0.0
 */
class AIOVG_Widget_Categories extends WP_Widget {
	
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
		
		$this->widget_slug = 'aiovg-widget-categories';

		$categories_settings = get_option( 'aiovg_categories_settings' );
		
		$this->defaults = array(
			'title'        => __( 'Categories', 'all-in-one-video-gallery' ),
			'child_of'     => 0,
			'orderby'      => $categories_settings['orderby'],
            'order'        => $categories_settings['order'],
			'hierarchical' => 1,	
			'show_count'   => $categories_settings['show_count'],
			'hide_empty'   => $categories_settings['hide_empty']			
		);
		
		parent::__construct( 
			$this->widget_slug, __( 'AIOVG - Video Categories', 'all-in-one-video-gallery' ), 
			array( 
				'classname'   => $this->widget_slug,
				'description' => __( 'A list or dropdown of video categories.', 'all-in-one-video-gallery' ),
			)
		);
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ), 11 );
	
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since    1.0.0
	 * @param	 array	  $args	       The array of form elements.
	 * @param    array    $instance    The current instance of the widget.
	 */
	public function widget( $args, $instance ) {

		// Merge incoming $instance array with $defaults
		if ( count( $instance ) ) {
			$attributes = array_merge( $this->defaults, $instance );
		} else {
			$attributes = $this->defaults;
		}
        
        $attributes['categories_li'] = wp_list_categories( array(
            'taxonomy'     => 'aiovg_categories',
            'child_of'     => (int) $attributes['child_of'],
			'orderby'      => sanitize_text_field( $attributes['orderby'] ),
            'order'        => sanitize_text_field( $attributes['order'] ),
            'hierarchical' => (int) $attributes['hierarchical'],
            'show_count'   => (int) $attributes['show_count'],
            'hide_empty'   => (int) $attributes['hide_empty'],            
            'title_li'     => '',
			'echo'         => false
        ) );

		// Process output
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . 'widgets/categories/templates/categories-list.php' );
	
		echo $args['after_widget'];

	}
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @since    1.0.0
	 * @param	 array    $new_instance    The new instance of values to be generated via the update.
	 * @param    array    $old_instance    The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		
		$instance['title']        = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['child_of']     = isset( $new_instance['child_of'] ) ? (int) $new_instance['child_of'] : 0;
		$instance['orderby']      = isset( $new_instance['orderby'] ) ? sanitize_text_field( $new_instance['orderby'] ) : 'name';
		$instance['order']        = isset( $new_instance['order'] ) ? sanitize_text_field( $new_instance['order'] ) : 'asc';
		$instance['hierarchical'] = isset( $new_instance['hierarchical'] ) ? 1 : 0;
		$instance['hide_empty']   = isset( $new_instance['hide_empty'] ) ? 1 : 0;
		$instance['show_count']   = isset( $new_instance['show_count'] ) ? 1 : 0;		
		
		return $instance;

	}
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @since    1.0.0
	 * @param    array    $instance    The array of keys and values for the widget.
	 */
	public function form( $instance ) {
		
		// Parse incoming $instance into an array and merge it with $defaults
		$instance = wp_parse_args(
			(array) $instance,
			$this->defaults
		);
			
		// Display the admin form
		include AIOVG_PLUGIN_DIR . 'widgets/categories/templates/admin.php';

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