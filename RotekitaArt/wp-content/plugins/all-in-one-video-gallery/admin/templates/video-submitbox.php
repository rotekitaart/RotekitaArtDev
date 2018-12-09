<?php

/**
 * Videos: Add new fields in the "Publish" metabox.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/admin/templates
 */
?>
    
<div class="misc-pub-section misc-pub-aiovg-featured">
	<label>
    	<input type="checkbox" name="featured" value="1" <?php checked( $featured, 1 ); ?> />
		<?php _e( "Mark as", 'all-in-one-video-gallery' ); ?>
        <strong><?php _e( "Featured", 'all-in-one-video-gallery' ); ?></strong>
   	</label>
</div>

<hr />

<div class="misc-pub-section misc-pub-aiovg-shortcode">
	<label>
		<strong><?php _e( "Video Shortcode", 'all-in-one-video-gallery' ); ?></strong>
    	<input type="text" class="widefat" readonly="readonly" value="[aiovg_video id=<?php echo (int) $post_id; ?>]" />
    </label>
</div>

<?php
// Add a nonce field
wp_nonce_field( 'aiovg_save_video_submitbox', 'aiovg_video_submitbox_nonce' );