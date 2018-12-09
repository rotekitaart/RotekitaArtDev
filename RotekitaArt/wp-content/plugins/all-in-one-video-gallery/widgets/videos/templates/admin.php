<?php

/**
 * Videos widget admin form.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/widgets/videos/templates
 */
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['title'] ); ?>" />
</p>

<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select Categories', 'all-in-one-video-gallery' ); ?></label> 
<ul id="<?php echo $this->get_field_id( 'category' ); ?>" class="aiovg-checklist widefat">
    <?php
    $args = array(
    'taxonomy'      => 'aiovg_categories',
    'selected_cats' => array_map( 'intval', $instance['category'] ),
    'walker'        => new AIOVG_Walker_Terms_Checklist( $this->get_field_name( 'category' ) ),
    'checked_ontop' => false
    ); 

    wp_terms_checklist( 0, $args );
    ?>
</ul>

<p>
    <label for="<?php echo $this->get_field_id( 'image_position' ); ?>"><?php _e( 'Image Position', 'all-in-one-video-gallery' ); ?></label>
    <select name="<?php echo $this->get_field_name( 'image_position' ); ?>" id="<?php echo $this->get_field_id( 'image_position' ); ?>" class="widefat"> 
        <?php
            $options = array(
                'top'  => __( 'Top', 'all-in-one-video-gallery' ),
                'left' => __( 'Left', 'all-in-one-video-gallery' )
            );
        
            foreach( $options as $key => $value ) {
                printf( '<option value="%s"%s>%s</option>', $key, selected( $key, $instance['image_position'] ), $value );
            }
        ?>
    </select>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php _e( 'Number of Columns', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'columns' ); ?>" id="<?php echo $this->get_field_id( 'columns' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['columns'] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'limit' ); ?>" id="<?php echo $this->get_field_id( 'limit' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'all-in-one-video-gallery' ); ?></label>
    <select name="<?php echo $this->get_field_name( 'orderby' ); ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat"> 
		<?php
			$options = array(
				'title' => __( 'Title', 'all-in-one-video-gallery' ),
				'date'  => __( 'Date Posted', 'all-in-one-video-gallery' ),
				'views' => __( 'Views Count', 'all-in-one-video-gallery' ),
				'rand'  => __( 'Random', 'all-in-one-video-gallery' )
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
    <input type="checkbox" name="<?php echo $this->get_field_name( 'featured' ); ?>" id="<?php echo $this->get_field_id( 'featured' ); ?>" value="1" <?php checked( 1, $instance['featured'] ); ?> />
    <label for="<?php echo $this->get_field_id( 'featured' ); ?>"><?php _e( 'Featured Only', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'related' ); ?>" id="<?php echo $this->get_field_id( 'related' ); ?>" value="1" <?php checked( 1, $instance['related'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'related' ); ?>">
		<?php _e( 'Follow URL?', 'all-in-one-video-gallery' ); ?> ( <?php _e( 'Related Videos', 'all-in-one-video-gallery' ); ?> )
    </label>
</p>

<p><?php _e( 'Show / Hide', 'all-in-one-video-gallery' ); ?></p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_category' ); ?>" id="<?php echo $this->get_field_id( 'show_category' ); ?>" value="1" <?php checked( 1, $instance['show_category'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_category' ); ?>"><?php _e( 'Category Name', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_date' ); ?>" id="<?php echo $this->get_field_id( 'show_date' ); ?>" value="1" <?php checked( 1, $instance['show_date'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Date Added', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_user' ); ?>" id="<?php echo $this->get_field_id( 'show_user' ); ?>" value="1" <?php checked( 1, $instance['show_user'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_user' ); ?>"><?php _e( 'Show User', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_views' ); ?>" id="<?php echo $this->get_field_id( 'show_views' ); ?>" value="1" <?php checked( 1, $instance['show_views'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_views' ); ?>"><?php _e( 'Views Count', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_duration' ); ?>" id="<?php echo $this->get_field_id( 'show_duration' ); ?>" value="1" <?php checked( 1, $instance['show_duration'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_duration' ); ?>"><?php _e( 'Video Duration', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" value="1" <?php checked( 1, $instance['show_excerpt'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Excerpt ( Short Description )', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_more' ); ?>" id="<?php echo $this->get_field_id( 'show_more' ); ?>" value="1" <?php checked( 1, $instance['show_more'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_more' ); ?>"><?php _e( 'Show More', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'more_label' ); ?>"><?php _e( 'More Label', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'more_label' ); ?>" id="<?php echo $this->get_field_id( 'more_label' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['more_label'] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'more_link' ); ?>"><?php _e( 'More Link', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'more_link' ); ?>" id="<?php echo $this->get_field_id( 'more_link' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['more_link'] ); ?>" />
</p>