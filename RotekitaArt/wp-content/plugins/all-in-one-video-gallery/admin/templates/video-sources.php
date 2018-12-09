<?php

/**
 * Videos: "Video Sources" meta box.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/admin/templates
 */
?>

<table class="aiovg-table widefat">
  	<tbody>
    	<tr>
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "Type", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>        
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Type", 'all-in-one-video-gallery' ); ?></strong></p>
      			<select name="type" id="aiovg-video-type" class="select">
                	<?php 
					$types = aiovg_get_video_source_types();
					foreach ( $types as $key => $label ) {
						printf( '<option value="%s"%s>%s</option>', $key, selected( $key, $type, false ), $label );
					}
					?>
        		</select>
      		</td>
    	</tr>
    	<tr class="aiovg-toggle-fields aiovg-type-default">
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "MP4", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "MP4", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap aiovg-media-uploader">
          			<input type="text" name="mp4" id="aiovg-mp4" class="text" placeholder="<?php _e( 'Enter your Direct File URL here (OR) use the Upload Media button', 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $mp4 ); ?>" />
          			<a class="button aiovg-upload-media hide-if-no-js" href="javascript:;" id="aiovg-upload-mp4" data-format="mp4">
		  				<?php _e( 'Upload Media', 'all-in-one-video-gallery' ); ?>
          			</a>
       			</div>
        
        		<br />
        
        		<ul class="aiovg-checkbox-list horizontal">
          			<li>
                    	<label>
                        	<input type="checkbox" name="has_webm" id="aiovg-has-webm" value="1" <?php checked( $has_webm, 1 ); ?> />
							<?php _e( "WebM", 'all-in-one-video-gallery' ); ?>
                        </label>
                    </li>
          			<li>
                    	<label>
                        	<input type="checkbox" name="has_ogv" id="aiovg-has-ogv" value="1" <?php checked( $has_ogv, 1 ); ?> />
							<?php _e( "OGV", 'all-in-one-video-gallery' ); ?>
                       	</label>
                	</li>
        		</ul>
      		</td>
    	</tr>
    	<tr id="aiovg-field-webm" class="aiovg-toggle-fields">
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "WebM", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "WebM", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap aiovg-media-uploader">
          			<input type="text" name="webm" id="aiovg-webm" class="text" placeholder="<?php _e( 'Enter your Direct File URL here (OR) use the Upload Media button', 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $webm ); ?>" />
          			<a class="button aiovg-upload-media hide-if-no-js" href="javascript:;" id="aiovg-upload-webm" data-format="webm">
		  				<?php _e( 'Upload Media', 'all-in-one-video-gallery' ); ?>
          			</a>
       			</div>
      		</td>
    	</tr>  
    	<tr id="aiovg-field-ogv" class="aiovg-toggle-fields">
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "OGV", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "OGV", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap aiovg-media-uploader">
          			<input type="text" name="ogv" id="aiovg-ogv" class="text" placeholder="<?php _e( 'Enter your Direct File URL here (OR) use the Upload Media button', 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $ogv ); ?>" />
          			<a class="button aiovg-upload-media hide-if-no-js" href="javascript:;" id="aiovg-upload-ogv" data-format="ogv">
		  				<?php _e( 'Upload Media', 'all-in-one-video-gallery' ); ?>
          			</a>
       			</div>
      		</td>
    	</tr>  
    	<tr class="aiovg-toggle-fields aiovg-type-youtube">
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "YouTube", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "YouTube", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="youtube" id="aiovg-youtube" class="text" placeholder="<?php _e( "Example: https://www.youtube.com/watch?v=twYp6W6vt2U", 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $youtube ); ?>" />
       			</div>
      		</td>
    	</tr>
    	<tr class="aiovg-toggle-fields aiovg-type-vimeo">
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "Vimeo", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Vimeo", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="vimeo" id="aiovg-vimeo" class="text" placeholder="<?php _e( "Example: https://vimeo.com/108018156", 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $vimeo ); ?>" />
       			</div>
      		</td>
    	</tr>
        <tr class="aiovg-toggle-fields aiovg-type-dailymotion">
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "Dailymotion", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Dailymotion", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="dailymotion" id="aiovg-dailymotion" class="text" placeholder="<?php _e( "Example: https://www.dailymotion.com/video/x11prnt", 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $dailymotion ); ?>" />
       			</div>
      		</td>
    	</tr>
        <tr class="aiovg-toggle-fields aiovg-type-facebook">
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "Facebook", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Facebook", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="facebook" id="aiovg-facebook" class="text" placeholder="<?php _e( "Example: https://www.facebook.com/facebook/videos/10155278547321729", 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $facebook ); ?>" />
       			</div>
      		</td>
    	</tr>
        <tr class="aiovg-toggle-fields aiovg-type-embedcode">
            <td class="label aiovg-hidden-xs">
                <label><?php _e( "Embed Code", 'all-in-one-video-gallery' ); ?></label>
            </td>
            <td>
                <p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Embed Code", 'all-in-one-video-gallery' ); ?></strong></p>
                <textarea name="embedcode" id="aiovg-embedcode" class="textarea" placeholder="<?php _e( 'Enter your Iframe Embed Code here', 'all-in-one-video-gallery' ); ?>" rows="6"><?php echo esc_textarea( $embedcode ); ?></textarea>
            </td>
        </tr>
        <?php do_action( 'aiovg_admin_add_video_source_fields', $post->ID ); ?>
   	 	<tr>
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "Image", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Image", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap aiovg-media-uploader">
          			<input type="text" name="image" id="aiovg-image" class="text" placeholder="<?php _e( 'Enter your Direct File URL here (OR) use the Upload Media button', 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $image ); ?>" />
          			<a class="button aiovg-upload-media hide-if-no-js" href="javascript:;" id="aiovg-upload-image" data-format="image">
		  				<?php _e( 'Upload Media', 'all-in-one-video-gallery' ); ?>
          			</a>
      			</div>
      		</td>
    	</tr> 
    	<tr>
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "Duration", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Duration", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="duration" id="aiovg-duration" class="text" placeholder="<?php _e( "6:30", 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_attr( $duration ); ?>" />
       			</div>
      		</td>
    	</tr>
    	<tr>
      		<td class="label aiovg-hidden-xs">
        		<label><?php _e( "Views", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php _e( "Views", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="views" id="aiovg-views" class="text" value="<?php echo esc_attr( $views ); ?>" />
       			</div>
      		</td>
    	</tr>     
  	</tbody>
</table>

<?php
// Add a nonce field
wp_nonce_field( 'aiovg_save_video_sources', 'aiovg_video_sources_nonce' );