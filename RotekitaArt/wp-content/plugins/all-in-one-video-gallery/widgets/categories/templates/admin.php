<?php

/**
 * Categories widget admin form.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/widgets/categories/templates
 */
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['title'] ); ?>">
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'child_of' ); ?>"><?php _e( 'Select Parent', 'all-in-one-video-gallery' ); ?></label> 
	<?php
    	wp_dropdown_categories( array(
        	'show_option_none'  => '-- '.__( 'Select Parent', 'all-in-one-video-gallery' ).' --',
			'option_none_value' => 0,
            'taxonomy'          => 'aiovg_categories',
            'name' 			    => $this->get_field_name( 'child_of' ),
			'class'             => 'widefat',
            'orderby'           => 'name',
			'selected'          => (int) $instance['child_of'],
            'hierarchical'      => true,
            'depth'             => 10,
            'show_count'        => false,
            'hide_empty'        => false,
        ) );
	?>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'all-in-one-video-gallery' ); ?></label>
    <select name="<?php echo $this->get_field_name( 'orderby' ); ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat"> 
		<?php
			$options = array(
				'id'    => __( 'ID', 'all-in-one-video-gallery' ),
				'count' => __( 'Count', 'all-in-one-video-gallery' ),
				'name'  => __( 'Name', 'all-in-one-video-gallery' ),
				'slug'  => __( 'Slug', 'all-in-one-video-gallery' )	
			);
		
			foreach( $options as $key => $value ) {
				printf( '<option value="%s"%s>%s</option>', $key, selected( $key, $instance['orderby'] ), $value );
			}
		?>
    </select>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order', 'all-in-one-video-gallery' ); ?></label>
    <select name="<?php echo $this->get_field_name( 'order' ); ?>" id="<?php echo $this->get_field_id( 'order' ); ?>" class="widefat"> 
		<?php
			$options = array(
				'asc'  => __( 'ASC', 'all-in-one-video-gallery' ),
				'desc' => __( 'DESC', 'all-in-one-video-gallery' )
			);
		
			foreach( $options as $key => $value ) {
				printf( '<option value="%s"%s>%s</option>', $key, selected( $key, $instance['order'] ), $value );
			}
		?>
    </select>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>" id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" value="1" <?php checked( 1, $instance['hierarchical'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>"><?php _e( ' Show Hierarchy', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_count' ); ?>" id="<?php echo $this->get_field_id( 'show_count' ); ?>" value="1" <?php checked( 1, $instance['show_count'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Show Video Counts', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" value="1" <?php checked( 1, $instance['hide_empty'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>"><?php _e( 'Hide Empty Categories', 'all-in-one-video-gallery' ); ?></label>
</p>