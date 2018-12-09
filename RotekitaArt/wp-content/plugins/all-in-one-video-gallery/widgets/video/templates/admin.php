<?php

/**
 * Video player widget admin form.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/widgets/video/templates
 */
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['title'] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Select a Video', 'all-in-one-video-gallery' ); ?></label> 
	<select name="<?php echo $this->get_field_name( 'id' ); ?>" id="<?php echo $this->get_field_id( 'id' ); ?>" class="widefat">
    	<option value="0">-- <?php _e( 'Latest Video', 'all-in-one-video-gallery' ); ?> --</option>
    	<?php
		$query = array( 
			'post_type'      => 'aiovg_videos', 
			'posts_per_page' => -1 ,
			'orderby'        => 'title', 
			'order'          => 'ASC', 
			'post_status'    => 'publish' 
		);		
		$videos = get_posts( $query );
		
		foreach ( $videos as $video ) {	
			printf(
				'<option value="%d"%s>%s</option>', 
				$video->ID, 
				selected( $video->ID, (int) $instance['id'] ), 
				esc_html( $video->post_title )
			);
		}
		?>
    </select>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'width' ); ?>" id="<?php echo $this->get_field_id( 'width' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['width'] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'ratio' ); ?>"><?php _e( 'Ratio', 'all-in-one-video-gallery' ); ?></label> 
	<input type="text" name="<?php echo $this->get_field_name( 'ratio' ); ?>" id="<?php echo $this->get_field_id( 'ratio' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['ratio'] ); ?>" />
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" id="<?php echo $this->get_field_id( 'autoplay' ); ?>" value="1" <?php checked( 1, $instance['autoplay'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e( 'Autoplay', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'loop' ); ?>" id="<?php echo $this->get_field_id( 'loop' ); ?>" value="1" <?php checked( 1, $instance['loop'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'loop' ); ?>"><?php _e( 'Loop', 'all-in-one-video-gallery' ); ?></label>
</p>

<p><?php _e( 'Show / Hide Player Controls', 'all-in-one-video-gallery' ); ?></p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'playpause' ); ?>" id="<?php echo $this->get_field_id( 'playpause' ); ?>" value="1" <?php checked( 1, $instance['playpause'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'playpause' ); ?>"><?php _e( 'Play / Pause', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'current' ); ?>" id="<?php echo $this->get_field_id( 'current' ); ?>" value="1" <?php checked( 1, $instance['current'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'current' ); ?>"><?php _e( 'Current Time', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'progress' ); ?>" id="<?php echo $this->get_field_id( 'progress' ); ?>" value="1" <?php checked( 1, $instance['progress'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'progress' ); ?>"><?php _e( 'Progressbar', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'duration' ); ?>" id="<?php echo $this->get_field_id( 'duration' ); ?>" value="1" <?php checked( 1, $instance['duration'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'duration' ); ?>"><?php _e( 'Duration', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'tracks' ); ?>" id="<?php echo $this->get_field_id( 'tracks' ); ?>" value="1" <?php checked( 1, $instance['tracks'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'tracks' ); ?>"><?php _e( 'Subtitles', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'volume' ); ?>" id="<?php echo $this->get_field_id( 'volume' ); ?>" value="1" <?php checked( 1, $instance['volume'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'volume' ); ?>"><?php _e( 'Volume', 'all-in-one-video-gallery' ); ?></label>
</p>

<p>
	<input type="checkbox" name="<?php echo $this->get_field_name( 'fullscreen' ); ?>" id="<?php echo $this->get_field_id( 'fullscreen' ); ?>" value="1" <?php checked( 1, $instance['fullscreen'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'fullscreen' ); ?>"><?php _e( 'Fullscreen', 'all-in-one-video-gallery' ); ?></label>
</p>