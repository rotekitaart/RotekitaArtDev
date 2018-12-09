<?php

/**
 * Videos: "Subtitles" meta box.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/admin/templates
 */
?>

<table id="aiovg-tracks" class="aiovg-table widefat">
	<tr class="aiovg-hidden-xs">
  		<th style="width: 5%;"></th>
    	<th><?php _e( 'File URL', 'all-in-one-video-gallery' ); ?></th>
    	<th style="width: 15%;"><?php _e( 'Label', 'all-in-one-video-gallery' ); ?></th>
    	<th style="width: 10%;"><?php _e( 'Srclang', 'all-in-one-video-gallery' ); ?></th>
    	<th style="width: 20%;"></th>
  	</tr>
  	<?php foreach ( $tracks as $key => $track ) : ?>
        <tr class="aiovg-tracks-row">
            <td class="aiovg-handle aiovg-hidden-xs"><span class="dashicons dashicons-sort"></span></td>
            <td>
                <p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "File URL", 'all-in-one-video-gallery' ); ?></strong></p>
                <div class="aiovg-input-wrap">
                    <input type="text" name="track_src[]" id="aiovg-track-<?php echo $key; ?>" class="text aiovg-track-src" placeholder="<?php echo __( "Enter your Direct File URL here (OR) use the Upload Media button", 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $track['src'] ); ?>" />
                </div>
            </td>
            <td>
                <p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Label", 'all-in-one-video-gallery' ); ?></strong></p>
                    <div class="aiovg-input-wrap">
                        <input type="text" name="track_label[]" class="text aiovg-track-label" placeholder="<?php echo __( "English", 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $track['label'] ); ?>" />
                    </div>
            </td>
            <td>
                <p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Srclang", 'all-in-one-video-gallery' ); ?></strong></p>
                <div class="aiovg-input-wrap">
                    <input type="text" name="track_srclang[]" class="text aiovg-track-srclang" placeholder="<?php echo __( "en", 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $track['srclang'] ); ?>" />
                </div>
            </td>
            <td>
                <p class="hide-if-no-js">
                    <a class="aiovg-upload-track" href="javascript:;"><?php _e( 'Upload File', 'all-in-one-video-gallery' ); ?></a>
                    <span class="aiovg-pipe-separator">|</span>
                    <a class="aiovg-delete-track" href="javascript:;"><?php _e( 'Delete', 'all-in-one-video-gallery' ); ?></a>
                </p>
            </td>
        </tr>
  	<?php endforeach; ?>
</table>

<p class="hide-if-no-js">
   	<a id="aiovg-add-new-track" class="button" href="javascript:;"><?php _e( 'Add New File', 'all-in-one-video-gallery' ); ?></a>
</p>

<table id="aiovg-tracks-clone" style="display: none;">
  	<tr class="aiovg-tracks-row">
    	<td class="aiovg-handle aiovg-hidden-xs"><span class="dashicons dashicons-sort"></span></td>
  		<td>
      		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "File URL", 'all-in-one-video-gallery' ); ?></strong></p>
      		<div class="aiovg-input-wrap">
        		<input type="text" name="track_src[]" class="text aiovg-track-src" placeholder="<?php echo __( "Enter your Direct File URL here (OR) use the Upload Media button", 'all-in-one-video-gallery' ); ?>" />
      		</div>
    	</td>
    	<td>
      		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Label", 'all-in-one-video-gallery' ); ?></strong></p>
      		<div class="aiovg-input-wrap">
        		<input type="text" name="track_label[]" class="text aiovg-track-label" placeholder="<?php echo __( "English", 'all-in-one-video-gallery' ); ?>" />
      		</div>
    	</td>
    	<td>
      		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Srclang", 'all-in-one-video-gallery' ); ?></strong></p>
      		<div class="aiovg-input-wrap">
        		<input type="text" name="track_srclang[]" class="text aiovg-track-srclang" placeholder="<?php echo __( "en", 'all-in-one-video-gallery' ); ?>" />
      		</div>
    	</td>
    	<td>
      		<p class="hide-if-no-js">
        		<a class="aiovg-upload-track" href="javascript:;"><?php _e( 'Upload File', 'all-in-one-video-gallery' ); ?></a>
        		<span class="aiovg-pipe-separator">|</span>
        		<a class="aiovg-delete-track" href="javascript:;"><?php _e( 'Delete', 'all-in-one-video-gallery' ); ?></a>
      		</p>
    	</td>
  	</tr>
</table>

<?php
// Add a nonce field
wp_nonce_field( 'aiovg_save_video_tracks', 'aiovg_video_tracks_nonce' );