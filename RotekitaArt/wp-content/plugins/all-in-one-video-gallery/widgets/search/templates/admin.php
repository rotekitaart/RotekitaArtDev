<?php

/**
 * Search widget admin form.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/widgets/search/templates
 */
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['title'] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Select Template', 'all-in-one-video-gallery' ); ?></label> 
	<select name="<?php echo $this->get_field_name( 'template' ); ?>" id="<?php echo $this->get_field_id( 'template' ); ?>" class="widefat">
    	<option value="vertical"<?php selected( $instance['template'], 'vertical' ); ?>><?php _e( 'Vertical', 'all-in-one-video-gallery' ); ?></option>
        <option value="horizontal"<?php selected( $instance['template'], 'horizontal' ); ?>><?php _e( 'Horizontal', 'all-in-one-video-gallery' ); ?></option>
    </select>
</p>

<p>
    <input type="checkbox" name="<?php echo $this->get_field_name( 'has_category' ); ?>" id="<?php echo $this->get_field_id( 'has_category' ); ?>" class="checkbox" value="1" <?php checked( 1, $instance['has_category'] ); ?> /> 
    <label for="<?php echo $this->get_field_id( 'has_category' ); ?>"><?php _e( 'Search by Categories', 'all-in-one-video-gallery' ); ?></label>
</p>