<?php

/**
 * Gallery, image positioned at the top.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/public/templates/videos
 */
?>

<div class="aiovg aiovg-widget aiovg-videos">
	<?php
    // Start the loop
    $class_column_container = 'col-md-' . floor( 12 / $attributes['columns'] );
    $i = 0; 
        
    while ( $aiovg_query->have_posts() ) : 
        
        $aiovg_query->the_post();
        
        $post_meta = get_post_meta( $post->ID );
        $image     = aiovg_get_image_url( $post_meta['image_id'][0], 'large', $post_meta['image'][0] );
            
        if ( $i % $attributes['columns'] == 0 ) echo '<div class="row">';
        ?>
            
        <div class="<?php echo esc_attr( $class_column_container ); ?>">
            <div class="thumbnail" data-id="<?php echo esc_attr( $post->ID ); ?>">
                <a href="<?php the_permalink(); ?>" class="aiovg-responsive-container" style="padding-bottom: <?php echo esc_attr( $attributes['ratio'] ); ?>;">
                    <img src="<?php echo esc_url( $image ); ?>" class="aiovg-responsive-element" />                    
                    
                    <?php if ( $attributes['show_duration'] && ! empty( $post_meta['duration'][0] ) ) : ?>
                    	<div class="aiovg-duration"><small><?php echo esc_html( $post_meta['duration'][0] ); ?></small></div>
                    <?php endif; ?>
                    
                    <img src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/images/play.png" class="aiovg-play" />
                </a>    	
                
                <div class="caption">
                    <h3 class="aiovg-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    
                        <?php
                        $meta = array();					
            
                        if ( $attributes['show_date'] ) {
                            $meta[] = sprintf( __( '%s ago', 'all-in-one-video-gallery' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
                        }
                                
                        if ( $attributes['show_user'] ) {
							$author_url = aiovg_get_user_videos_page_url( $post->post_author );
                            $meta[]     = sprintf( '%s <a href="%s">%s</a>', __( 'by', 'all-in-one-video-gallery' ), esc_url( $author_url ), esc_html( get_the_author() ) );			
                        }
        
                        if ( count( $meta ) ) {
							printf( '<div class="aiovg-user"><small>%s</small></div>', __( "Posted", 'all-in-one-video-gallery' ) . ' ' . implode( ' ', $meta ) );
                        }
                        ?>
                    </h3>
                        
                    <?php if ( $attributes['show_excerpt'] ) : ?>
                    	<div class="aiovg-excerpt"><?php the_aiovg_excerpt( $attributes['excerpt_length'] ); ?></div>
                    <?php endif; ?>
                    
                    <?php
                    if ( $attributes['show_category'] ) {
                        $categories = get_the_terms( get_the_ID(), 'aiovg_categories' );
                        if ( ! empty( $categories ) ) {
                            $meta = array();
                            foreach ( $categories as $category ) {
								$category_url = aiovg_get_category_page_url( $category );
                                $meta[]       = sprintf( '<a href="%s" class="text-primary">%s</a>', esc_url( $category_url ), esc_html( $category->name ) );
                            }
                            printf( '<div class="aiovg-category"><i class="fa fa-folder-open-o" aria-hidden="true"></i> <small>%s</small></div>', implode( ', ', $meta ) );
                        }
                    }
                    ?>
                    
                    <?php if ( $attributes['show_views'] ) : ?>
                        <div class="aiovg-views">
                            <i class="fa fa-eye" aria-hidden="true"></i> <small><?php printf( __( '%d views', 'all-in-one-video-gallery' ), $post_meta['views'][0] ); ?></small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
                
        <?php 
        $i++;
        if ( 0 == $i % $attributes['columns'] || $i == $aiovg_query->post_count ) echo '</div>';
             
    // End of the loop
    endwhile;
        
    // Use reset postdata to restore orginal query
    wp_reset_postdata();
        
    // More button
    if ( $attributes['show_more'] ) : ?>
        <p class="aiovg-more text-center">
            <a href="<?php echo esc_url( $attributes['more_link'] ); ?>" class="btn btn-default"><?php echo esc_html( $attributes['more_label'] ); ?></a>
        </p>
    <?php endif; ?>
</div>