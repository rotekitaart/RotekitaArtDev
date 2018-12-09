<?php

/**
 * Single video page.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/public/templates
 */
?>

<div class="aiovg aiovg-single-video">
    <!-- Player -->
    <?php echo the_aiovg_player( $attributes['id'] ); ?>

    <!-- Meta informations -->
    <div class="aiovg-meta">
        <?php
        $meta = array();					
        
        // Author & Date
        $user_meta = array();
        
        if ( $attributes['show_date'] ) {
            $user_meta[] = sprintf( __( 'Posted %s ago', 'all-in-one-video-gallery' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
        }
                
        if ( $attributes['show_user'] ) {
			$author_url  = aiovg_get_user_videos_page_url( $post->post_author );
            $user_meta[] = sprintf( '<a href="%s">%s</a>', esc_url( $author_url ), get_the_author() );			
        }
        
        if ( count( $user_meta ) ) {
            $meta[] = sprintf( '<div class="aiovg-user"><small>%s</small></div>', implode( ' ' . __( "by", 'all-in-one-video-gallery' ) . ' ', $user_meta ) );
        }
        
        // Category(s)
        if ( $attributes['show_category'] && ! empty( $attributes['categories'] ) ) {
            $term_meta = array();
            foreach ( $attributes['categories'] as $category ) {
				$category_url = aiovg_get_category_page_url( $category );
                $term_meta[]  = sprintf( '<a class="text-primary" href="%s">%s</a>', esc_url( $category_url ), esc_html( $category->name ) );
            }
            $meta[] = sprintf( '<div class="aiovg-category"><i class="fa fa-folder-open-o" aria-hidden="true"></i> %s</div>', implode( ', ', $term_meta ) );
        }
        
        // ...
        if ( count( $meta ) ) {
            printf( '<div class="pull-left">%s</div>', implode( '', $meta ) );
        }
        ?>  
        
        <!-- Views count -->
        <?php if ( $attributes['show_views'] ) : ?>
            <div class="aiovg-views pull-right">
                <i class="fa fa-eye" aria-hidden="true"></i>
                <?php
                    $views_count = get_post_meta( get_the_ID(), 'views', true );
                    printf( __( '%d views', 'all-in-one-video-gallery' ), $views_count );
                ?>
            </div>
        <?php endif; ?>
        
        <div class="clearfix"></div>
    </div>
    
    <!-- Description -->
    <div class="aiovg-description"><?php echo $content; ?></div>
    
    <!-- Socialshare buttons -->
    <?php the_aiovg_socialshare_buttons(); ?>
</div>

<?php
// Related videos
if ( $attributes['related'] ) {
	$atts = array();
	
	$atts[] = 'title="' . __( 'You may also like', 'all-in-one-video-gallery' ) . '"';
	
	if ( ! empty( $attributes['categories'] ) ) {
		$ids = array();
		foreach ( $attributes['categories'] as $category ) {
			$ids[] = $category->term_id;
		}
		$atts[] = 'category="' . implode( ',', $ids ) . '"';
	}
	
	$atts[] = 'exclude="' . $attributes['id'] . '"';
	$atts[] = 'show_count="0"';

	$related_videos = do_shortcode( '[aiovg_videos ' . implode( ' ', $atts ) . ']' );
		
	if ( ! empty( $related_videos ) ) {
		echo $related_videos;
	} 
}