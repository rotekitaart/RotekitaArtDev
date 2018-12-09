<?php

/**
 * Helper Functions.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/includes
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Prevent wp_kses from removing iframe embeds.
 * 
 * @since     1.0.0
 * @param     array    $allowed_tags    Allowed HTML Tags
 * @return    array                     Iframe included.
 */
function aiovg_allow_iframes_filter( $allowed_tags ) {

	// Only change for users who has "unfiltered_html" capability
	if ( ! current_user_can( 'unfiltered_html' ) ) return $allowed_tags;
	
	// Allow iframes and the following attributes
	$allowed_tags['iframe'] = array(
		'align'        => true,
		'width'        => true,
		'height'       => true,
		'frameborder'  => true,
		'name'         => true,
		'src'          => true,
		'id'           => true,
		'class'        => true,
		'style'        => true,
		'scrolling'    => true,
		'marginwidth'  => true,
		'marginheight' => true,
	);
	
	return $allowed_tags;
	
}

/*
 * Check if Yoast SEO plugin is active and AIOVG can use that.
 *
 * @since     1.5.6
 * @return    bool     $can_use_yoast    True if can use Yoast, false if not.
 */
function aiovg_can_use_yoast() {

	$can_use_yoast = false;

	if ( in_array( 'wordpress-seo/wp-seo.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$can_use_yoast = true;
	}

	return $can_use_yoast;

}

/*
 * Whether the current user has a specific capability.
 *
 * @since     1.0.0
 * @param     string    $capability    Capability name.
 * @param     int       $post_id       Optional. ID of the specific object to check against if
 									  `$capability` is a "meta" cap.
 * @return    bool                     True if the current user has the capability, false if not.
 */
function aiovg_current_user_can( $capability, $post_id = 0 ) {

	$user_id = get_current_user_id();
	
	// If editing, deleting, or reading a video, get the post and post type object
	if ( 'edit_aiovg_video' == $capability || 'delete_aiovg_video' == $capability || 'read_aiovg_video' == $capability ) {
		$post = get_post( $post_id );
		$post_type = get_post_type_object( $post->post_type );

		// If editing a video, assign the required capability
		if ( 'edit_aiovg_video' == $capability ) {
			if ( $user_id == $post->post_author ) {
				$capability = 'edit_aiovg_videos';
			} else {
				$capability = 'edit_others_aiovg_videos';
			}
		}
		
		// If deleting a video, assign the required capability
		elseif ( 'delete_aiovg_video' == $capability ) {
			if ( $user_id == $post->post_author ) {
				$capability = 'delete_aiovg_videos';
			} else {
				$capability = 'delete_others_aiovg_videos';
			}
		}
		
		// If reading a private video, assign the required capability
		elseif ( 'read_aiovg_video' == $capability ) {
			if ( 'private' != $post->post_status ) {
				$capability = 'read';
			} elseif ( $user_id == $post->post_author ) {
				$capability = 'read';
			} else {
				$capability = 'read_private_aiovg_videos';
			}
		}
		
	}
		
	return current_user_can( $capability );
	
}

/**
 * Delete category attachments.
 *
 * @since    1.0.0
 * @param    int      $term_id    Term ID.
 */
function aiovg_delete_category_attachments( $term_id ) {
	  
	$image_id = get_term_meta( $term_id, 'image_id', true );
	if ( ! empty( $image_id ) ) wp_delete_attachment( $image_id, true );

}

/**
 * Delete video attachments.
 *
 * @since    1.0.0
 * @param    int      $post_id    Post ID.
 */
function aiovg_delete_video_attachments( $post_id ) {
	  
	$mp4_id = get_post_meta( $post_id, 'mp4_id', true );
	if ( ! empty( $mp4_id ) ) wp_delete_attachment( $mp4_id, true );
	
	$webm_id = get_post_meta( $post_id, 'webm_id', true );
	if ( ! empty( $webm_id ) ) wp_delete_attachment( $webm_id, true );
	
	$ogv_id = get_post_meta( $post_id, 'ogv_id', true );
	if ( ! empty( $ogv_id ) ) wp_delete_attachment( $ogv_id, true );
	
	$image_id = get_post_meta( $post_id, 'image_id', true );
	if ( ! empty( $image_id ) ) wp_delete_attachment( $image_id, true );
	
	$tracks = get_post_meta( $post_id, 'track' );	
	if ( count( $tracks ) ) {
		foreach ( $tracks as $key => $track ) {
			if ( 'src_id' == $key ) wp_delete_attachment( (int) $track['src_id'], true );
		}
	}

}

/**
 * Get attachment ID of the given URL.
 * 
 * @since     1.0.0
 * @param     string    $url      Media file URL.
 * @param     string    $media    "image" or "video". Type of the media. 
 * @return    int                 Attachment ID on success, 0 on failure.
 */
function aiovg_get_attachment_id( $url, $media = 'image' ) {

	$attachment_id = 0;
	
	if ( empty( $url ) ) {
		return $attachment_id;
	}	
	
	if ( 'image' == $media ) {

		$dir = wp_upload_dir();
	
		if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
	
			$file = basename( $url );
	
			$query_args = array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'fields'      => 'ids',
				'meta_query'  => array(
					array(
						'value'   => $file,
						'compare' => 'LIKE',
						'key'     => '_wp_attachment_metadata',
					),
				)
			);
	
			$query = new WP_Query( $query_args );
	
			if ( $query->have_posts() ) {
	
				foreach ( $query->posts as $post_id ) {
	
					$meta = wp_get_attachment_metadata( $post_id );
	
					$original_file       = basename( $meta['file'] );
					$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
	
					if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
						$attachment_id = $post_id;
						break;
					}
	
				}
	
			}
	
		}
	
	} else {

		$url = wp_make_link_relative( $url );
		
		if ( ! empty( $url ) ) {
			global $wpdb;
			
			$query = $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid RLIKE %s", $url );
			$attachment_id = $wpdb->get_var( $query );
		}
		
	}

	return $attachment_id;
	
}

/**
 * Get the category page URL.
 *
 * @since     1.0.0
 * @param     object    $term    The term object.
 * @return    string             Category page URL.
 */
function aiovg_get_category_page_url( $term ) {

	$page_settings = get_option( 'aiovg_page_settings' );
	
	$url = '/';
	
	if ( $page_settings['category'] > 0 ) {
		$url = get_permalink( $page_settings['category'] );
	
		if ( '' != get_option( 'permalink_structure' ) ) {
    		$url = user_trailingslashit( trailingslashit( $url ) . $term->slug );
  		} else {
    		$url = add_query_arg( 'aiovg_category', $term->slug, $url );
  		}
	}
  
	return $url;

}

/*
 * Get Dailymotion ID from URL.
 *
 * @since     1.5.0
 * @param     string    $url    Dailymotion page URL.
 * @return    string    $id     Dailymotion video ID.
 */
function aiovg_get_dailymotion_id_from_url( $url ) {
	
	$id = '';
	
	if ( preg_match( '!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!', $url, $m ) ) {
        if ( isset( $m[6] ) ) {
            $id = $m[6];
        }
		
        if ( isset( $m[4] ) ) {
            $id = $m[4];
        }
		
        $id = $m[2];
    }

	return $id;
	
}

/*
 * Get Dailymotion image from URL.
 *
 * @since     1.5.0
 * @param     string    $url    Dailymotion page URL.
 * @return    string    $url    Dailymotion image URL.
 */
function aiovg_get_dailymotion_image_url( $url ) {
	
	$id  = aiovg_get_dailymotion_id_from_url( $url );		
	$url = '';
	
	if ( ! empty( $id ) ) {
		$dailymotion = file_get_contents( 'https://api.dailymotion.com/video/' . $id . '?fields=thumbnail_large_url,thumbnail_medium_url' );
		$dailymotion = json_decode( $dailymotion, TRUE );

		if ( isset( $dailymotion['thumbnail_large_url'] ) ) {
			$url = $dailymotion['thumbnail_large_url'];
		} else {
			$url = $dailymotion['thumbnail_medium_url'];
		}
	}
    	
	return $url;
	
}

/*
 * Get default plugin settings.
 *
 * @since     1.5.3
 * @return    array    $defaults    Array of plugin settings.
 */
function aiovg_get_default_settings() {

	$defaults = array(
		'aiovg_general_settings' => array(
			'bootstrap'          => array( 
				'css' => 'css'
			),
			'fontawesome'        => 1,
			'delete_plugin_data' => 1
		),
		'aiovg_player_settings' => array(
			'width'    => '',
			'ratio'    => 56.25,
			'autoplay' => 1,
			'loop'     => 0,
			'preload'  => 'metadata',
			'controls' => array(
				'playpause'  => 'playpause',
				'current'    => 'current',
				'progress'   => 'progress', 
				'duration'   => 'duration',
				'tracks'     => 'tracks',
				'volume'     => 'volume', 
				'fullscreen' => 'fullscreen'					
			)
		),
		'aiovg_brand_settings' => array(
			'show_logo'      => 1,
			'logo_image'     => '',
			'logo_link'      => home_url(),
			'logo_position'  => 'bottomleft',
			'logo_margin'    => 8,
			'copyright_text' => sprintf( __( 'Proudly by "%s"', 'all-in-one-video-gallery' ), get_option( 'blogname' ) )
		),
		'aiovg_image_settings' => array(
			'ratio' => 75
		),
		'aiovg_categories_settings' => array(
			'columns'          => 3,
			'orderby'          => 'name',
			'order'            => 'asc',
			'show_description' => 1,
			'show_count'       => 1,				
			'hide_empty'       => 0
		),
		'aiovg_videos_settings' => array(
			'columns'        => 3,
			'limit'          => 10,
			'orderby'        => 'date',
			'order'          => 'desc',
			'display'        => array(
				'count'    => 'count',
				'category' => 'category',
				'date'     => 'date',
				'user'     => 'user',
				'views'    => 'views',
				'duration' => 'duration',
				'excerpt'  => 'excerpt'
			),
			'excerpt_length' => 75
		),
		'aiovg_video_settings' => array(
			'display'      => array( 
				'category' => 'category', 
				'date'     => 'date', 
				'user'     => 'user', 
				'views'    => 'views', 
				'related'  => 'related'
			),
			'has_comments' => 1
		),
		'aiovg_privacy_settings' => array(
			'show_consent'         => 0,
			'consent_message'      => __( '<strong>Please accept cookies to play this video</strong>. By accepting you will be accessing content from a service provided by an external third party.', 'all-in-one-video-gallery' ),
			'consent_button_label' => __( 'Accept', 'all-in-one-video-gallery' )
		),
		'aiovg_permalink_settings' => array(
			'video' => 'aiovg_videos'
		),
		'aiovg_socialshare_settings' => array(				
			'services' => array( 
				'facebook'  => 'facebook',
				'twitter'   => 'twitter',
				'gplus'     => 'gplus',
				'linkedin'  => 'linkedin',
				'pinterest' => 'pinterest'
			)
		),
		'aiovg_page_settings' => aiovg_insert_custom_pages()			
	);
		
	return $defaults;
		
}

/*
 * Get image from the Iframe Embed Code.
 *
 * @since     1.0.0
 * @param     string    $embedcode    Iframe Embed Code.
 * @return    string    $url          Image URL.
 */
function aiovg_get_embedcode_image_url( $embedcode ) {
	
	$document = new DOMDocument();
  	$document->loadHTML( $embedcode );
	
	$iframes = $document->getElementsByTagName( 'iframe' ); 
	$src = $iframes->item(0)->getAttribute( 'src' );

	// YouTube
	$url = aiovg_get_youtube_image_url( $src );
	
	// Vimeo
	if ( empty( $url ) ) {
		$url = aiovg_get_vimeo_image_url( $src );
	}
	
	// Dailymotion
	if ( empty( $url ) ) {
		$url = aiovg_get_dailymotion_image_url( $src );
	}
    	
	// Return image url
	return $url;
	
}

/**
 * Get the video excerpt.
 *
 * @since     1.0.0
 * @param     int       $char_length    Excerpt length.
 * @return    string    $content        Excerpt content.
 */
function aiovg_get_excerpt( $char_length = 55 ) {

	global $post;
	
	$excerpt = wp_strip_all_tags( $post->post_content, true );
	$char_length++;
	
	$content = '';

	if ( mb_strlen( $excerpt ) > $char_length ) {
		$subex = mb_substr( $excerpt, 0, $char_length - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$content = mb_substr( $subex, 0, $excut );
		} else {
			$content = $subex;
		}
		$content .= '[...]';
	} else {
		$content = $excerpt;
	}
	
	return $content;
	
}

/*
 * Get image URL using the attachment ID.
 *
 * @since     1.0.0
 * @param     integer    $id         Attachment ID.
 * @param     string     $size       Size of the image.
 * @param     string     $default    Default image URL.
 * @param     string     $type       "gallery" or "player".
 * @return    string     $url        Image URL.
 */
function aiovg_get_image_url( $id, $size = "large", $default = '', $type = 'gallery' ) {

	$url = '';
	
	// Get image from attachment
	if ( $id ) {
		$attributes = wp_get_attachment_image_src( (int) $id, $size );
		if ( ! empty( $attributes ) ) {
			$url = $attributes[0];
		}
	}
	
	// Set default image if empty
	if ( 'gallery' == $type && empty( $default ) ) {
		$default = AIOVG_PLUGIN_URL . 'public/assets/images/placeholder-image.png';
	}
	
	if ( empty( $url ) ) {
		$url = $default;
	}
	
	// Return image url
	return $url;

}

/*
 * Get message to display based on the $type input.
 *
 * @since     1.0.0
 * @param     string    $type       Type of the message.
 * @return    string    $message    Message to display.
 */
function aiovg_get_message( $type ) {

	$message = '';
	
	switch ( $type ) {
		case 'empty':
			$message = __( 'No Items found.', 'all-in-one-video-gallery' );
			break;
	}
	
	return $message;
	
}

/**
 * Get current page number.
 *
 * @since     1.0.0
 * @return    int      $paged    The current page number.
 */
function aiovg_get_page_number() {

	global $paged;
	
	if ( get_query_var( 'paged' ) ) {
    	$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
    	$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}
    	
	return absint( $paged );
		
}

/**
 * Get player HTML.
 * 
 * @since     1.0.0
 * @param     int       $post_id    Post ID.
 * @param     array     $atts       Player configuration data.
 * @return    string    $html       Player HTML.
 */
function aiovg_get_player_html( $post_id = 0, $atts = array() ) {

	// Vars
	$player_settings = get_option( 'aiovg_player_settings' );

	$attributes = array_merge( array(
		'width'       => $player_settings['width'],
		'ratio'       => $player_settings['ratio'],
		'mp4'         => '',
		'webm'        => '',
		'ogv'         => '',
		'youtube'     => '',
		'vimeo'       => '',
		'dailymotion' => '',
		'facebook'    => '',
		'poster'      => '',
		'autoplay'    => '',
		'loop'        => '',
		'playpause'   => '',
		'current'     => '',
		'progress'    => '',
		'duration'    => '',
		'tracks'      => '',
		'volume'      => '',
		'fullscreen'  => ''
	), $atts );
	
	$url = aiovg_get_player_page_url( $post_id, $attributes );
	
	// Process output
	$html = '';
	
	if ( ! empty( $url ) ) {
			
		$url = esc_url( $url );
		$iframe = sprintf( '<iframe width="560" height="315" src="%s" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>', $url );
		
		if ( $post_id > 0 ) {
	
			$post_meta = get_post_meta( $post_id );
						
			if ( 'embedcode' == $post_meta['type'][0] ) {
			
				$is_youtube = ( false !== strpos( $url, 'youtube.com' ) );
				$is_vimeo = ( false !== strpos( $url, 'vimeo.com' ) );
				$is_dailymotion = ( false !== strpos( $url, 'dailymotion.com' ) );
				$is_facebook = ( false !== strpos( $url, 'facebook.com' ) );
				
				if ( $is_youtube || $is_vimeo || $is_dailymotion || $is_facebook ) {
				
					$privacy_settings = get_option( 'aiovg_privacy_settings' );
					
					$show_consent = 1;
							
					if ( isset( $_COOKIE['aiovg_gdpr_consent'] ) || empty( $privacy_settings['show_consent'] ) || empty( $privacy_settings['consent_message'] ) || empty( $privacy_settings['consent_button_label'] ) ) {
						$show_consent = 0;
					}
					
					if ( $show_consent ) {

						$video = add_query_arg( 'autoplay', 1, $url );
						$image = aiovg_get_image_url( $post_meta['image_id'][0], 'large', $post_meta['image'][0], 'player' );
						
						$iframe  = sprintf( '<iframe width="560" height="315" data-src="%s" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>', $video );
						$iframe .= sprintf( '<div class="aiovg-privacy-wrapper" style="background-image: url(%s);">', $image );
						$iframe .= '<div class="aiovg-privacy-consent-block">';
						$iframe .= sprintf( '<div class="aiovg-privacy-consent-message">%s</div>', wp_kses_post( $privacy_settings['consent_message'] ) );
						$iframe .= sprintf( '<div class="aiovg-privacy-consent-button">%s</div>', sanitize_text_field( $privacy_settings['consent_button_label'] ) );
						$iframe .= '</div>';
						$iframe .= '</div>';
					
					}
				
				}
				
			}
			
		}
		
		$html   = sprintf( 
			'<div class="aiovg-player-container" style="max-width: %s;"><div class="aiovg-player" style="padding-bottom: %s;">%s</div></div>', 
			! empty( $attributes['width'] ) ? (int) $attributes['width'] . 'px' : '100%', 
			! empty( $attributes['ratio'] ) ? (float) $attributes['ratio'] . '%' : '56.25%', 
			$iframe 
		);		
		
	}

	// Return
	return $html;

}

/**
 * Get player page URL.
 * 
 * @since     1.0.0
 * @param     int       $post_id    Post ID.
 * @param     array     $atts       Player configuration data.
 * @return    string    $url        Player page URL.
 */
function aiovg_get_player_page_url( $post_id = 0, $atts = array() ) {

	$page_settings = get_option( 'aiovg_page_settings' );

	$url = '';
	
	if ( $page_settings['player'] > 0 ) {
		$url = get_permalink( $page_settings['player'] );
	
		$id = $post_id;
		
		if ( empty( $id ) ) {

			global $post;
						
			if ( isset( $post ) ) {
				$id = $post->ID;
			}

		}
		
		if ( ! empty( $id ) ) {
			if ( '' != get_option( 'permalink_structure' ) ) {
				$url = user_trailingslashit( trailingslashit( $url ) . 'id/' . $id );
			} else {
				$url = add_query_arg( array( 'aiovg_type' => 'id', 'aiovg_video' => $id ), $url );
			}
		}
	}
	
	$query_args = array();
	
	foreach ( $atts as $key => $value ) {
		if ( '' !== $value ) {
			switch ( $key ) {
				case 'mp4':
				case 'webm':
				case 'ogv':
				case 'youtube':
				case 'vimeo':
				case 'dailymotion':
				case 'facebook':
				case 'poster':
					$query_args[ $key ] = urlencode( $atts[ $key ] );
					break;
				case 'autoplay':
				case 'loop':
				case 'playpause':
				case 'current':
				case 'progress':
				case 'duration':
				case 'tracks':
				case 'volume':
				case 'fullscreen':
					$query_args[ $key ] = (int) $atts[ $key ];
					break;
			}
		}
	}
	
	if ( ! empty( $query_args ) ) {
		$url = add_query_arg( $query_args, $url );
	}
	
	// Parse URL from iframe embedcode
	if ( $post_id > 0 ) {
	
		$type = get_post_meta( $post_id, 'type', true );
		
		if ( 'embedcode' == $type ) {
			$embedcode = get_post_meta( $post_id, 'embedcode', true );
			
			$document = new DOMDocument();
			$document->loadHTML( $embedcode );
			
			$iframes = $document->getElementsByTagName( 'iframe' ); 
			$url = $iframes->item(0)->getAttribute( 'src' );
		}
		
	}

	// Return
	return apply_filters( 'aiovg_player_page_url', $url, $post_id, $atts );

}

/**
 * Generate the search results page URL.
 *
 * @since     1.0.0
 * @return    string    Search results page URL.
 */
function aiovg_get_search_page_url() {

	$page_settings = get_option( 'aiovg_page_settings' );
	
	$url = '/';
	
	if ( $page_settings['search'] > 0 ) {
		$url = get_permalink( $page_settings['search'] );
	}
	
	return $url;
	
}

/**
 * Get the user videos page URL.
 *
 * @since     1.0.0
 * @param     int       $user_id    User ID.
 * @return    string                User videos page URL.
 */
function aiovg_get_user_videos_page_url( $user_id ) {

	$page_settings = get_option( 'aiovg_page_settings' );
	
	$url = '/';

	if ( $page_settings['user_videos'] > 0 ) {	
		$url = get_permalink( $page_settings['user_videos'] );	
		$user_slug = get_the_author_meta( 'user_nicename', $user_id );
		
		if ( '' != get_option( 'permalink_structure' ) ) {
    		$url = user_trailingslashit( trailingslashit( $url ) . $user_slug );
  		} else {
    		$url = add_query_arg( 'aiovg_user', $user_slug, $url );
  		}		
	}
  
	return $url;

}

/**
 * Get video source types.
 * 
 * @since     1.0.0
 * @return    array    Array of source types.
 */
function aiovg_get_video_source_types() {

	$types = array(
		'default'     => __( 'Self Hosted', 'all-in-one-video-gallery' ) . ' / ' . __( 'External URL', 'all-in-one-video-gallery' ),
		'youtube'     => __( 'YouTube', 'all-in-one-video-gallery' ),
		'vimeo'       => __( 'Vimeo', 'all-in-one-video-gallery' ),
		'dailymotion' => __( 'Dailymotion', 'all-in-one-video-gallery' ),
		'facebook'    => __( 'Facebook', 'all-in-one-video-gallery' ),
		'embedcode'   => __( 'Iframe Embed Code', 'all-in-one-video-gallery' )
	);
	
	return apply_filters( 'aiovg_video_source_types', $types );

}

/*
 * Get Vimeo ID from URL.
 *
 * @since     1.0.0
 * @param     string    $url    Vimeo page URL.
 * @return    string    $id     Vimeo video ID.
 */
function aiovg_get_vimeo_id_from_url( $url ) {
	
	$id = '';
	
    $is_vimeo = preg_match( '/vimeo\.com/i', $url );	
	if ( $is_vimeo ) {
    	$id = preg_replace( '/[^\/]+[^0-9]|(\/)/', '', rtrim( $url, '/' ) );
  	}

	return $id;
	
}

/*
 * Get Vimeo image from URL.
 *
 * @since     1.0.0
 * @param     string    $url    Vimeo page URL.
 * @return    string    $url    Vimeo image URL.
 */
function aiovg_get_vimeo_image_url( $url ) {
	
	$id  = aiovg_get_vimeo_id_from_url( $url );		
	$url = '';
	
	if ( ! empty( $id ) ) {
		$vimeo = unserialize( file_get_contents( "https://vimeo.com/api/v2/video/$id.php" ) );
		$url = $vimeo[0]['thumbnail_large'];
	}
    	
	return $url;
	
}

/*
 * Get YouTube ID from URL.
 *
 * @since     1.0.0
 * @param     string    $url    YouTube page URL.
 * @return    string    $id     YouTube video ID.
 */
function aiovg_get_youtube_id_from_url( $url ) {
	
	$id  = '';
    $url = parse_url( $url );
		
    if ( 0 === strcasecmp( $url['host'], 'youtu.be' ) ) {
       	$id = substr( $url['path'], 1 );
    } elseif ( 0 === strcasecmp( $url['host'], 'www.youtube.com' ) ) {
       	if ( isset( $url['query'] ) ) {
       		parse_str( $url['query'], $url['query'] );
           	if ( isset( $url['query']['v'] ) ) {
           		$id = $url['query']['v'];
           	}
       	}
			
       	if ( empty( $id ) ) {
           	$url['path'] = explode( '/', substr( $url['path'], 1 ) );
           	if ( in_array( $url['path'][0], array( 'e', 'embed', 'v' ) ) ) {
               	$id = $url['path'][1];
           	}
       	}
    }
    	
	return $id;
	
}

/*
 * Get YouTube image from URL.
 *
 * @since     1.0.0
 * @param     string    $url    YouTube page URL.
 * @return    string    $url    YouTube image URL.
 */
function aiovg_get_youtube_image_url( $url ) {
	
	$id  = aiovg_get_youtube_id_from_url( $url );
	$url = '';

	if ( ! empty( $id ) ) {
		$url = "https://img.youtube.com/vi/$id/0.jpg"; 
	}
	   	
	return $url;
	
}

/*
 * Inserts a new key/value after the key in the array.
 *
 * @since     1.0.0
 * @param     string    $key          The key to insert after.
 * @param     array     $array        An array to insert in to.
 * @param     array     $new_array    An array to insert.
 * @return                            The new array if the key exists, FALSE otherwise.
 */
function aiovg_insert_array_after( $key, $array, $new_array ) {

	if ( array_key_exists( $key, $array ) ) {
    	$new = array();
    	foreach ( $array as $k => $value ) {
      		$new[ $k ] = $value;
      		if ( $k === $key ) {
				foreach ( $new_array as $new_key => $new_value ) {
        			$new[ $new_key ] = $new_value;
				}
      		}
    	}
    	return $new;
  	}
		
  	return $array;
  
}

/**
 * Insert required custom pages and return their IDs as array.
 * 
 * @since     1.0.0
 * @return    array    Array of created page IDs.
 */
function aiovg_insert_custom_pages() {

	// Vars
	$page_settings = get_option( 'aiovg_page_settings', array() );

	$page_definitions = array(
		'category' => array( 
			'title'   => __( 'Video Category', 'all-in-one-video-gallery' ), 
			'content' => '[aiovg_category]' 
		),
		'search' => array( 
			'title'   => __( 'Search Videos', 'all-in-one-video-gallery' ), 
			'content' => '[aiovg_search]' 
		),
		'user_videos' => array( 
			'title'   => __( 'User Videos', 'all-in-one-video-gallery' ), 
			'content' => '[aiovg_user_videos]' 
		),
		'player' => array( 
			'title'   => __( 'Player Embed', 'all-in-one-video-gallery' ), 
			'content' => '' 
		)
	);
	
	// ...
	$pages = array();
	
	foreach ( $page_definitions as $slug => $page ) {

		$id = 0;
		
		if ( array_key_exists( $slug, $page_settings ) ) {
			$id = (int) $page_settings[ $slug ];
		}

		if ( ! $id ) {
			$id = wp_insert_post(
				array(
					'post_title'     => $page['title'],
					'post_content'   => $page['content'],
					'post_status'    => 'publish',
					'post_author'    => 1,
					'post_type'      => 'page',
					'comment_status' => 'closed'
				)
			);
		}				
			
		$pages[ $slug ] = $id;
			
	}

	return $pages;

}

/**
  * Removes an item or list from the query string.
  *
  * @since     1.0.0
  * @param     string|array    $key      Query key or keys to remove.
  * @param     bool|string     $query    When false uses the $_SERVER value. Default false.
  * @return    string                    New URL query string.
  */
function aiovg_remove_query_arg( $key, $query = false ) {

	if ( is_array( $key ) ) { // removing multiple keys
		foreach ( $key as $k ) {
			$query = str_replace( '#038;', '&', $query );
			$query = add_query_arg( $k, false, $query );
		}
		
		return $query;
	}
		
	return add_query_arg( $key, false, $query );
	
}

/**
 * Sanitize the array inputs.
 *
 * @since     1.0.0
 * @param     array    $value    Input array.
 * @return    array              Sanitized array.
 */
function aiovg_sanitize_array( $value ) {
	return ! empty( $value ) ? array_map( 'esc_attr', $value ) : array();
}

/**
 * Sanitize the integer inputs, accepts empty values.
 *
 * @since     1.0.0
 * @param     string|int    $value    Input value.
 * @return    string|int              Sanitized value.
 */
function aiovg_sanitize_int( $value ) {

	$value = intval( $value );
	return ( 0 == $value ) ? '' : $value;
	
}

/**
 * Update video views count.
 *
 * @since    1.0.0
 * @param    int      $post_id    Post ID
 */
function aiovg_update_views_count( $post_id ) {
				
	$user_ip = $_SERVER['REMOTE_ADDR']; // Retrieve the current IP address of the visitor
	$key     = $user_ip . '_aiovg_' . $post_id; // Combine post ID & IP to form unique key
	$value   = array( $user_ip, $post_id ); // Store post ID & IP as separate values
	$visited = get_transient( $key ); // Get transient and store in variable

	// Check to see if the post ID/IP ($key) address is currently stored as a transient
	if ( false === $visited ) {

		// Store the unique key, Post ID & IP address for 12 hours if it does not exist
		set_transient( $key, $value, 60 * 60 * 12 );

		// Now run post views function
		$count = (int) get_post_meta( $post_id, 'views', true );
		update_post_meta( $post_id, 'views', ++$count );

	}

}

/**
 * Display the video excerpt.
 *
 * @since    1.0.0
 * @param    int      $char_length    Excerpt length.
 */
function the_aiovg_excerpt( $char_length ) {
	echo aiovg_get_excerpt( $char_length );
}

/**
 * Display paginated links for video pages.
 *
 * @since    1.0.0
 * @param    int      $numpages     The total amount of pages.
 * @param    int      $pagerange    How many numbers to either side of current page.
 * @param    int      $paged        The current page number.
 */
function the_aiovg_pagination( $numpages = '', $pagerange = '', $paged = '' ) {

  	if ( $numpages == '' ) {
    	global $wp_query;
    	
		$numpages = $wp_query->max_num_pages;
    	if ( ! $numpages ) {
        	$numpages = 1;
    	}
  	}
	
	if ( empty( $pagerange ) ) {
    	$pagerange = 2;
  	}

  	if ( empty( $paged ) ) {
    	$paged = aiovg_get_page_number();
  	}

  	// Construct the pagination arguments to enter into our paginate_links function
	$arr_params = array( 'vi', 'ca', 'lang' );
	 
	$base = aiovg_remove_query_arg( $arr_params, get_pagenum_link( 1 ) );
	
	if ( ! get_option('permalink_structure') || isset( $_GET['aiovg'] ) ) {
		$prefix = strpos( $base, '?' ) ? '&' : '?';
    	$format = $prefix.'paged=%#%';
    } else {
		$prefix = ( '/' == substr( $base, -1 ) ) ? '' : '/';
    	$format = $prefix.'page/%#%';
    } 
	
  	$pagination_args = array(
    	'base'         => $base . '%_%',
    	'format'       => $format,
    	'total'        => $numpages,
    	'current'      => $paged,
    	'show_all'     => false,
    	'end_size'     => 1,
    	'mid_size'     => $pagerange,
    	'prev_next'    => true,
    	'prev_text'    => __( '&laquo;' ),
    	'next_text'    => __( '&raquo;' ),
    	'type'         => 'array',
    	'add_args'     => false,
    	'add_fragment' => ''
  	);

  	$paginate_links = paginate_links( $pagination_args );

  	if ( $paginate_links ) {
		echo '<div class="aiovg-pagination text-center">';
		
		echo '<ul class="pagination">'; 		   	
		foreach ( $paginate_links as $key => $page_link ) {
		
			if ( false !== strpos( $page_link, 'current' ) ) {
			 	printf( '<li class="active">%s</li>', $page_link );
			} else {
				printf( '<li>%s</li>', $page_link );
			}
			
		}
   		echo '</ul>';
		
		echo '<div class="text-muted">';
		echo '<small>' . sprintf( __( 'Page %d of %d', 'all-in-one-video-gallery' ), $paged, $numpages ) . '</small>';
		echo '</div>';
		
		echo '</div>';
  	}

}

/**
 * Display a video player.
 * 
 * @since    1.0.0
 * @param    int      $post_id    Post ID.
 * @param    array    $atts       Player configuration data.
 */
function the_aiovg_player( $post_id = 0, $atts = array() ) {

	echo aiovg_get_player_html( $post_id, $atts );	
	
	// Update views count for Iframe Embed Codes
	if ( $post_id > 0 ) {
		$type = get_post_meta( $post_id, 'type', true );
		if ( 'embedcode' == $type ) {
			aiovg_update_views_count( $post_id );
		}
	}
}

/**
 * Display social sharing buttons.
 *
 * @since    1.0.0
 */
function the_aiovg_socialshare_buttons() {

	global $post;
	
	$socialshare_settings = get_option( 'aiovg_socialshare_settings' );
	
	if ( is_singular( 'aiovg_videos' ) ) {
 
 		// Get current page url
		$url = get_permalink();
		
		// Get current page title
		$title = get_the_title();
		$title = str_replace( ' ', '%20', $title );
	
		// Get image
		$image_url = get_post_meta( $post->ID, 'image', true );
		$image_id  = get_post_meta( $post->ID, 'image_id', true );
		
		$image = aiovg_get_image_url( $image_id, 'large', $image_url, 'player' );	
 
		// Build sharing buttons
		$buttons = array();
	
		if ( isset( $socialshare_settings['services']['facebook'] ) ) {
			$facebook  = "https://www.facebook.com/sharer/sharer.php?u={$url}";
			$buttons[] = sprintf( '<a class="aiovg-social-link aiovg-social-facebook" href="%s" target="_blank">%s</a>', $facebook, __( 'Facebook', 'all-in-one-video-gallery' ) );
		}

		if ( isset( $socialshare_settings['services']['twitter'] ) ) {
			$twitter   = "https://twitter.com/intent/tweet?text={$title}&amp;url={$url}";
			$buttons[] = sprintf( '<a class="aiovg-social-link aiovg-social-twitter" href="%s" target="_blank">%s</a>', $twitter, __( 'Twitter', 'all-in-one-video-gallery' ) );
		}

		if ( isset( $socialshare_settings['services']['gplus'] ) ) {
			$google    = "https://plus.google.com/share?url={$url}";
			$buttons[] = sprintf( '<a class="aiovg-social-link aiovg-social-googleplus" href="%s" target="_blank">%s</a>', $google, __( 'Google+', 'all-in-one-video-gallery' ) );
		}
	
		if ( isset( $socialshare_settings['services']['linkedin'] ) ) {
			$linkedin  = "https://www.linkedin.com/shareArticle?url={$url}&amp;title={$title}";
			$buttons[] = sprintf( '<a class="aiovg-social-link aiovg-social-linkedin" href="%s" target="_blank">%s</a>', $linkedin, __( 'Linkedin', 'all-in-one-video-gallery' ) );
		}

		if ( isset( $socialshare_settings['services']['pinterest'] ) ) {
			$pinterest = "https://pinterest.com/pin/create/button/?url={$url}&amp;media={$image}&amp;description={$title}";
			$buttons[] = sprintf( '<a class="aiovg-social-link aiovg-social-pinterest" href="%s" target="_blank">%s</a>', $pinterest, __( 'Pin It', 'all-in-one-video-gallery' ) );
		}
	
		if ( count( $buttons ) ) {
			printf( '<div class="aiovg-social">%s</div>', implode( ' ', $buttons ) );
		}
	
	}

}

/**
 * Build & display attributes using the $atts array.
 * 
 * @since    1.0.0
 * @param    array    $atts    Array of attributes.
 */
function the_aiovg_video_attributes( $atts ) {

	$attributes = array();
	
	foreach ( $atts as $key => $value ) {
		if ( '' === $value ) {
			$attributes[] = $key;
		} else {
			$attributes[] = sprintf( '%s="%s"', $key, $value );
		}
	}
	
	echo implode( ' ', $attributes );

}