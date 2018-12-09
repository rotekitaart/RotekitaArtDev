<?php

/**
 * Welcome page.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/admin/templates
 */
?>

<div id="aiovg-welcome" class="wrap about-wrap full-width-layout aiovg-welcome">

	<h1><?php printf( __( 'Welcome to "All-in-One Video Gallery - %s"', 'all-in-one-video-gallery' ), AIOVG_PLUGIN_VERSION ); ?></h1>
    
    <p class="about-text">
		<?php _e( 'Responsive & Lightweight Video gallery plugin. No coding required. Add/Manage videos through a dedicated custom post interface, group them by categories, customize the front-end display using the shortcode builder as you need, provide the option for users to search videos, plus everything you will need to build a YouTube/Vimeo like video sharing website.', 'all-in-one-video-gallery' ); ?>
    </p>
        
	<div class="wp-badge aiovg-badge"></div>
    
    <h2 class="nav-tab-wrapper wp-clearfix">
		<?php		
        foreach ( $tabs as $tab => $title ) {
            $class = ( $tab == $active_tab ) ? 'nav-tab nav-tab-active' : 'nav-tab';
            printf( '<a href="%s" class="%s">%s</a>', esc_url( admin_url( add_query_arg( 'page', $tab, 'index.php' ) ) ), $class, $title );
        }
        ?>
    </h2>
    
    <?php if ( 'aiovg_about' == $active_tab ) : ?>
        <p class="about-description">
            <?php _e( "Built over the WordPress' Native Video Player. Supports any browser & video formats such as MP4, WebM, OGV and embeddable players like YouTube, Vimeo, Dailymotion, Facebook, etc.", 'all-in-one-video-gallery' ); ?>
        </p>
        
        <div class="changelog">    
            <div class="two-col">
                <div class="col">
                	<!-- Settings -->
                    <h3>
                    	<span class="dashicons dashicons-admin-generic"></span> 
                        <a href="<?php echo admin_url( 'edit.php?post_type=aiovg_videos&page=aiovg_settings' ); ?>">
							<?php _e( 'Settings', 'all-in-one-video-gallery' ); ?>
                        </a>
                    </h3>
                    
                    <p>
                        <?php _e( 'Highly customizable. Complete control over the player & gallery display. Configure what and how to display. Example: Number of Columns in a Gallery, Autoplay a Video, etc.', 'all-in-one-video-gallery' ); ?>
                    </p>
                    
                    <br />
                    
                	<!-- Categories -->
                    <h3>
                    	<span class="dashicons dashicons-portfolio"></span> 
						<a href="<?php echo admin_url( 'edit-tags.php?taxonomy=aiovg_categories&post_type=aiovg_videos' ); ?>">
							<?php _e( 'Categories &rarr; Add', 'all-in-one-video-gallery' ); ?>
                       	</a>
                    </h3>
                    
                    <p>
                        <?php printf( __( 'Unlimited Categories. Categories help you organize your videos in a flexible way. Use %s shortcode to display the categories in the front-end.', 'all-in-one-video-gallery' ), '<code>[aiovg_categories]</code>' ); ?>
                    </p>

					<br />
                    
                    <!-- Videos -->
                    <h3>
                    	<span class="dashicons dashicons-playlist-video"></span> 
                    	<a href="<?php echo admin_url( 'post-new.php?post_type=aiovg_videos' ); ?>">
							<?php _e( 'Video Gallery &rarr; Add New', 'all-in-one-video-gallery' ); ?>
                        </a>
                    </h3>
                    
                    <p>
                        <?php printf( __( 'Uploading the video files is simple. To add your first video post, simply click Add New and then fill out the video details. By default, the videos are displayed using their own custom POST page. Use %s shortcode to show the video in your own POST or PAGE.', 'all-in-one-video-gallery' ), '<code>[aiovg_video]</code>' ); ?>
                    </p>
                </div>
                
                <div class="col">
                	<!-- Shortcode Builder -->
                    <h3><span class="dashicons dashicons-editor-code"></span> <?php _e( 'Shortcode Builder', 'all-in-one-video-gallery' ); ?></h3>
                    
                    <p>
                        <?php _e( 'Stop worrying about the shortcode attributes. Comes with a beautiful shortcode builder that makes integration easy. Look at the "Video Player & Gallery" button on top of the WP Editor in your POSTS or PAGES.', 'all-in-one-video-gallery' ); ?>
                    </p>
                    
                    <br />
                    
                    <!-- Widgets -->
                    <h3>
                    	<span class="dashicons dashicons-tagcloud"></span>
						<?php _e( 'Widgets', 'all-in-one-video-gallery' ); ?>
                    </h3>
                    
                    <p>
                        <?php _e( 'Widgets to search videos, list categories, display videos grid and to add a video player. Videos widget can be configured to show the latest, popular or only featured or videos from selective categories, videos related to the current playing video, etc.', 'all-in-one-video-gallery' ); ?>
                    </p>
                    
                    <br />
                    
                    <!-- More Features -->
                    <h3>
                    	<span class="dashicons dashicons-plus"></span> 
						<?php _e( 'More Features', 'all-in-one-video-gallery' ); ?>
                    </h3>
                    
                    <p>
                        <?php _e( 'Custom Logo & Branding, GDPR Consent, Subtitles, Comments, Social Sharing, Pagination and lot more.', 'all-in-one-video-gallery' ); ?>
                    </p>
                </div>
            </div>        
        </div>
    <?php endif; ?>
    
    <?php if ( 'aiovg_support' == $active_tab ) : ?>
    	<p class="about-description"><?php _e( 'Need Help?', 'all-in-one-video-gallery' ); ?></p>
        
        <div class="changelog">    
            <div class="two-col">
                <div class="col">
                	<h3><?php _e( 'Phenomenal Support', 'all-in-one-video-gallery' ); ?></h3>
                    
                    <p>
                        <?php printf( __( 'We do our best to provide the best support we can. If you encounter a problem or have a question, simply submit your question using our <a href="%s" target="_blank">support form</a>.', 'all-in-one-video-gallery' ), 'https://wordpress.org/support/plugin/all-in-one-video-gallery' ); ?>
                    </p>
                </div>
                
                <div class="col">
                	<h3><?php _e( 'Need Even Faster Support?', 'all-in-one-video-gallery' ); ?></h3>
                    
                    <p>
                        <?php printf( __( 'Our <a href="%s" target="_blank">Priority Support</a> system is there for customers that need faster and/or more in-depth assistance.', 'all-in-one-video-gallery' ), 'https://plugins360.com/support/' ); ?>
                    </p>
                </div>                
          	</div>
      	</div>
    <?php endif; ?>

</div>