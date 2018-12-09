<?php

/**
 * Video Player.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/public/templates
 */
 
$player_settings  = get_option( 'aiovg_player_settings' );
$brand_settings   = get_option( 'aiovg_brand_settings' );
$privacy_settings = get_option( 'aiovg_privacy_settings' );

$post_id = (int) get_query_var( 'aiovg_video', 0 );
$post_meta = array();

if ( $post_id > 0 ) {
	$post_type = get_post_type( $post_id );
		
	if ( 'aiovg_videos' == $post_type ) {
		$post_meta = get_post_meta( $post_id );
	}
}

// Video Sources
$types = array(
	'all'         => array( 'mp4', 'webm', 'ogv', 'youtube', 'vimeo', 'dailymotion', 'facebook' ),
	'default'     => array( 'mp4', 'webm', 'ogv' ),
	'youtube'     => array( 'youtube' ),
	'vimeo'       => array( 'vimeo' ),
	'dailymotion' => array( 'dailymotion' ),
	'facebook'    => array( 'facebook' )
);

if ( ! empty( $post_meta ) ) {
	$types = array_key_exists( $post_meta['type'][0], $types ) ? $types[ $post_meta['type'][0] ] : array();	
} else {
	$types = $types['all'];
}

$sources = array();
$thirdparty_providers = array();

foreach ( $types as $type ) {

	if ( ! empty( $post_meta ) ) {
		$src = ! empty( $post_meta[ $type ][0] ) ? $post_meta[ $type ][0] : '';
	} else {
		$src = isset( $_GET[ $type ] ) ? sanitize_text_field( $_GET[ $type ] ) : '';
	}
	
	if ( ! empty( $src ) ) {		
		$mime = "video/{$type}";

		$sources[] = array(
			'type' => $mime,
			'src'  => $src
		);
		
		if ( 'youtube' === $type || 'vimeo' === $type || 'dailymotion' === $type || 'facebook' === $type ) {
			$thirdparty_providers[] = $type;	
		}
	}
	
}

$sources = apply_filters( 'aiovg_video_sources', $sources );

// Video Attributes
$attributes = array( 
	'id'          => 'player',
	'playsinline' => ''
);

if ( ! wp_is_mobile() ) {

	$autoplay = isset( $_GET['autoplay'] ) ? (int) $_GET['autoplay'] : $player_settings['autoplay'];
	
	if ( ! empty( $autoplay ) ) {
		$attributes['autoplay'] = true;
	}
	
}

$loop = isset( $_GET['loop'] ) ? (int) $_GET['loop'] : $player_settings['loop'];

if ( ! empty( $loop ) ) {
	$attributes['loop'] = true;
}

$attributes['preload'] = esc_attr( $player_settings['preload'] );

if ( isset( $_GET['poster'] ) ) {
	$attributes['poster'] = $_GET['poster'];
} elseif ( ! empty( $post_meta ) ) {
	$attributes['poster'] = aiovg_get_image_url( $post_meta['image_id'][0], 'large', $post_meta['image'][0], 'player' );
}

if( ! empty( $attributes['poster'] ) ) {
	$attributes['poster'] = esc_url( $attributes['poster'] );
	
	if ( false !== strpos( $attributes['poster'], 'youtube' ) ) {
		$attributes['poster'] = str_replace( array( 'https:', 'http:' ), '', $attributes['poster'] );
	}
}

$use_native_controls  = 0;
$show_privacy_consent = 0;

if ( count( $thirdparty_providers ) > 0 ) {
	
	if ( wp_is_mobile() ) {
		$use_native_controls  = 1;
	}
	
	if ( ! ( isset( $_COOKIE['aiovg_gdpr_consent'] ) || empty( $privacy_settings['show_consent'] ) || empty( $privacy_settings['consent_message'] ) || empty( $privacy_settings['consent_button_label'] ) ) ) {		
		$use_native_controls  = 0;
		$show_privacy_consent = 1;
	} 

}

if ( 1 == $use_native_controls ) {
	$attributes['poster']   = '';
	$attributes['controls'] = '';
}

$attributes = apply_filters( 'aiovg_video_attributes', $attributes );

// Player Settings
$features = array( 'playpause', 'current', 'progress', 'duration', 'tracks', 'volume', 'fullscreen' );
$controls = array( 'aiovg' );

foreach ( $features as $feature ) {
	
	if ( isset( $_GET[ $feature ] ) ) {
	
		if ( 1 == (int) $_GET[ $feature ] ) {
			$controls[] = $feature;
		}
		
	} else {
	
		if ( isset( $player_settings['controls'][ $feature ] ) ) {
			$controls[] = $feature;
		}
		
	}
	
}

$settings = array(
	'pluginPath'               => AIOVG_PLUGIN_URL . 'public/assets/mediaelement/',
	'features'                 => $controls,
	'iPadUseNativeControls'    => $use_native_controls,
	'iPhoneUseNativeControls'  => $use_native_controls,
	'AndroidUseNativeControls' => $use_native_controls,
	'youtube'                  => array( 'showinfo' => 0, 'rel' => 0, 'iv_load_policy' => 3 )	
);

$settings = apply_filters( 'aiovg_player_settings', $settings );

// Video Tracks
$tracks = array();

if ( in_array( 'tracks', $settings['features'] ) && ! empty( $post_meta['track'] ) ) {

	foreach ( $post_meta['track'] as $track ) {
		$tracks[] = unserialize( $track );
	}
	
}

$tracks = apply_filters( 'aiovg_video_tracks', $tracks );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">    
    <?php if ( $post_id > 0 ) : ?>    
        <title><?php echo wp_kses_post( get_the_title( $post_id ) ); ?></title>    
        <link rel="canonical" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" />
        <meta property="og:url" content="<?php echo esc_url( get_permalink( $post_id ) ); ?>" />
    <?php endif; ?>
	<link rel="stylesheet" href="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/mediaelement/mediaelementplayer.css?v=4.2.9" />

	<?php do_action( 'aiovg_player_head' ); ?>

	<style type="text/css">
        html, 
        body, 
        video, 
        iframe {
            width: 100% !important;
            height: 100% !important;
            margin:0 !important; 
            padding:0 !important; 
            overflow: hidden;
        }
            
        video, 
        iframe {
            display: block;
        }
            
        .mejs__container, 
        .mejs__layer {
            width: 100% !important;
            height: 100% !important;
        }
        
        .mejs__captions-layer {
            pointer-events: none;
        }
		
		.mejs__logo {
			position: absolute;	
			width: auto !important;
			height: auto !important;
			max-width: 150px;
			z-index: 9;
			cursor: pointer;
		}
		
		.mejs__logo img {
			display: block;
			opacity: 0.5;
		}
		
		.mejs__logo:hover img {
			opacity: 1;
		}
		
		.mejs__logo-topleft {
			top: 0;
			left: 0;
		}
		
		.mejs__logo-topright {
			top: 0;
			right: 0;
		}
		
		.mejs__logo-bottomleft {
			bottom: 40px;
			left: 0;
		}
		
		.mejs__logo-bottomright {
			bottom: 40px;
			right: 0;
		}
		
		.mejs__privacy {
            color: #FFF;
            text-align: center;
            z-index: 999;
        }
        
        .mejs__privacy-consent-block {
            margin: 15px;
            padding: 15px;
            background: #000;
            border-radius: 3px;
            opacity: 0.9;
        }
        
        .mejs__privacy-consent-button {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 15px;
            background: #F00;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .mejs__privacy-consent-button:hover {
            opacity: 0.8;
        }
		
		.contextmenu {
            position: absolute;
            top: 0;
            left: 0;
            margin: 0;
            padding: 0;
            background: #fff;
			border-radius: 2px;
			box-shadow: 1px 1px 2px #333;
            z-index: 9999999999; /* make sure it shows on fullscreen */
        }
        
        .contextmenu-item {
            margin: 0;
            padding: 8px 12px;
            font-family: 'Helvetica', Arial, serif;
            font-size: 12px;
            color: #222;		
            white-space: nowrap;
            cursor: pointer;
        }
    </style>
</head>
<body<?php if ( 1 == $use_native_controls ) echo ' style="background-color: #000;"'; ?>>
    <video <?php the_aiovg_video_attributes( $attributes ); ?>>
        <?php 
		// Video Sources
		if ( 0 == $show_privacy_consent ) {
			foreach ( $sources as $source ){
				printf( '<source type="%s" src="%s" />', esc_attr( $source['type'] ), esc_url_raw( $source['src'] ) );
			}
		}
		
		// Video Tracks
		foreach ( $tracks as $track ) {
        	printf( '<track src="%s" kind="subtitles" srclang="%s" label="%s">', esc_url_raw( $track['src'] ), esc_attr( $track['srclang'] ), esc_attr( $track['label'] ) );
		}
       ?>       
	</video>
    
    <?php if ( ! empty( $brand_settings['copyright_text'] ) ) : ?>
        <div id="contextmenu" class="contextmenu" style="display: none;">
            <div class="contextmenu-item"><?php echo $brand_settings['copyright_text']; ?></div>
        </div>
    <?php endif; ?>
    
	<script src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/mediaelement/mediaelement-and-player.min.js?v=4.2.9" type="text/javascript"></script>
    <?php if ( in_array( 'vimeo', $thirdparty_providers ) ) : ?>
        <script src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/mediaelement/renderers/vimeo.min.js?v=4.2.9" type="text/javascript"></script>
    <?php endif; ?>
    <?php if ( in_array( 'dailymotion', $thirdparty_providers ) ) : ?>
        <script src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/mediaelement/renderers/dailymotion.min.js?v=4.2.9" type="text/javascript"></script>
    <?php endif; ?>
    <?php if ( in_array( 'facebook', $thirdparty_providers ) ) : ?>
        <script src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/mediaelement/renderers/facebook.min.js?v=4.2.9" type="text/javascript"></script>
    <?php endif; ?>
    
    <?php do_action( 'aiovg_player_footer' ); ?>
    
    <script type="text/javascript">
		(function() {
			'use strict';
			
			///////////////////////////////////////
		  	///////////////////////////////////////
		  	//
		  	// H E L P E R    F U N C T I O N S
		  	//
		  	///////////////////////////////////////
		  	///////////////////////////////////////
			  
			function ajaxSubmit( params, id ) {
			
				var xmlhttp;
	
				if ( window.XMLHttpRequest ) {
					xmlhttp = new XMLHttpRequest();
				} else {
					xmlhttp = new ActiveXObject( 'Microsoft.XMLHTTP' );
				};
				
				xmlhttp.onreadystatechange = function() {
				
					if ( 4 == xmlhttp.readyState && 200 == xmlhttp.status ) {
					
						if ( xmlhttp.responseText && 'store_privacy_cookie' == id ) {
							// Reload document
							window.location.reload();
						}
						
					}
					
				};	
	
				xmlhttp.open( 'POST', '<?php echo admin_url( 'admin-ajax.php' ); ?>', true );
				xmlhttp.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
				xmlhttp.send( params );
							
			}
			
			///////////////////////////////////////
		  	///////////////////////////////////////
		  	//
		  	// C O R E    F U N C T I O N S
		  	//
		  	///////////////////////////////////////
		  	///////////////////////////////////////
			
			/**
			 * A custom mediaelementjs plugin.
			 */
			Object.assign(mejs.MepDefaults, {
				showLogo: '<?php echo (int) $brand_settings['show_logo']; ?>',
				logoImage: '<?php echo esc_url_raw( $brand_settings['logo_image'] ); ?>',
				logoLink: '<?php echo esc_url_raw( $brand_settings['logo_link'] ); ?>',
				logoPosition: '<?php echo sanitize_text_field( $brand_settings['logo_position'] ); ?>',
				logoMargin: '<?php echo (int) $brand_settings['logo_margin']; ?>',
				showPrivacyConsent: '<?php echo $show_privacy_consent; ?>',
				privacyConsentMessage: '<?php echo wp_kses_post( $privacy_settings['consent_message'] ); ?>',
				privacyConsentButtonLabel: '<?php echo sanitize_text_field( $privacy_settings['consent_button_label'] ); ?>',
				showCustomContextMenu: '<?php echo ! empty( $brand_settings['copyright_text'] ) ? 1 : 0; ?>'
				
			});
			
			Object.assign(MediaElementPlayer.prototype, {
			
				buildaiovg: function buildaiovg( player, controls, layers, media ) {
					
					var t = this;
					
					// Logo / Watermark
					if ( 1 == t.options.showLogo && '' != t.options.logoImage ) {
					
						t.logoLayer = document.createElement( 'div' );
						t.logoLayer.className = t.options.classPrefix + 'logo ' + t.options.classPrefix + 'logo-' + t.options.logoPosition;
						t.logoLayer.style.margin = t.options.logoMargin + 'px';
						t.logoLayer.innerHTML = '<img src="' + t.options.logoImage + '" />';
							
						t.layers.appendChild( t.logoLayer );
						
						if ( '' != t.options.logoLink ) {
							t.logoLayer.addEventListener( 'click', function() {
								top.window.location.href = t.options.logoLink;
							});
						}
						
						t.container.addEventListener( 'controlsshown', function() {
							t.logoLayer.style.display = '';
						});
						
						t.container.addEventListener( 'controlshidden', function() {
							t.logoLayer.style.display = 'none';
						});
						
					}
					
					// Privacy Consent
					if ( 1 == t.options.showPrivacyConsent ) {	
							
						t.privacyLayer = document.createElement( 'div' );
						t.privacyLayer.className = t.options.classPrefix + 'overlay ' + t.options.classPrefix + 'layer ' + t.options.classPrefix + 'privacy';
						t.privacyLayer.innerHTML = ( '<div class="' + t.options.classPrefix + 'privacy-consent-block">' ) + ( '<div class="' + t.options.classPrefix + 'privacy-consent-message">' + t.options.privacyConsentMessage + '</div>' ) + ( '<div class="' + t.options.classPrefix + 'privacy-consent-button">' + t.options.privacyConsentButtonLabel + '</div>' ) + '</div>';
						
						t.layers.appendChild( t.privacyLayer );
						
						t.privacyLayer.querySelector( '.' + t.options.classPrefix + 'privacy-consent-button' ).addEventListener( 'click',  t.aiovgOnAgreeToPrivacy.bind( t ) );	
								
					}
					
					// Custom ContextMenu
					if ( 1 == t.options.showCustomContextMenu ) {
					
						var contextmenu = document.getElementById( 'contextmenu' );
						var timeout_handler = '';
						
						document.addEventListener( 'contextmenu', function( e ) {
						
							if ( 3 === e.keyCode || 3 === e.which ) {
								e.preventDefault();
								e.stopPropagation();
								
								var width = contextmenu.offsetWidth,
									height = contextmenu.offsetHeight,
									x = e.pageX,
									y = e.pageY,
									doc = document.documentElement,
									scrollLeft = ( window.pageXOffset || doc.scrollLeft ) - ( doc.clientLeft || 0 ),
									scrollTop = ( window.pageYOffset || doc.scrollTop ) - ( doc.clientTop || 0 ),
									left = x + width > window.innerWidth + scrollLeft ? x - width : x,
									top = y + height > window.innerHeight + scrollTop ? y - height : y;
						
								contextmenu.style.display = '';
								contextmenu.style.left = left + 'px';
								contextmenu.style.top = top + 'px';
								
								clearTimeout( timeout_handler );
								timeout_handler = setTimeout(function() {
									contextmenu.style.display = 'none';
								}, 1500 );				
							}
														 
						});
						
						if ( '' != t.options.logoLink ) {
							contextmenu.addEventListener( 'click', function() {
								top.window.location.href = t.options.logoLink;
							});
						}
						
						document.addEventListener( 'click', function() {
							contextmenu.style.display = 'none';								 
						});
						
					}
							
				},
				
				aiovgOnAgreeToPrivacy: function aiovgOnAgreeToPrivacy() {
					
					var t = this;
					
					t.privacyLayer.querySelector( '.' + t.options.classPrefix + 'privacy-consent-button' ).innerHTML = '<?php _e( 'Please wait', 'all-in-one-video-gallery' ); ?>...';	
					
					// Set Cookie
					ajaxSubmit( 'action=aiovg_set_cookie', 'store_privacy_cookie' );
						
				}
					
			});
			 
			/**
			 * Initialize the player.
			 */
			var settings = <?php echo json_encode( $settings ); ?>;
			
			settings.success = function( media ) {
						
				// Fired when the media is ready to start playing
				var views_count_updated = 0;
						
				media.addEventListener( 'play', function( e ) {
					if ( ! views_count_updated ) {
						ajaxSubmit( 'action=aiovg_update_views_count&post_id=<?php echo $post_id; ?>&security=<?php echo wp_create_nonce( 'aiovg_video_{$post_id}_views_nonce' ); ?>', 'update_views_count' );
						views_count_updated = 1;
					};
				});
					
			}
			
			var player = new MediaElementPlayer( 'player', settings );
		})();
    </script>
</body>
</html>