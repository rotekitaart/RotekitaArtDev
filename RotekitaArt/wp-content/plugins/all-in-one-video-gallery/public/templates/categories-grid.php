<?php

/**
 * Categories grid - [aiovg_categories].
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/public/templates
 */
?>

<div class="aiovg aiovg-categories">
	<?php
    // Display the title (if applicable)
    if ( ! empty( $attributes['title'] ) ) : ?>
        <h3 class="aiovg-header"><?php echo esc_html( $attributes['title'] ); ?></h3>
    <?php 
    endif;
    
    // Start the loop
    $class_column_container = 'col-md-' . floor( 12 / $attributes['columns'] );
                
    foreach ( $terms as $key => $term ) {
    
		$permalink = aiovg_get_category_page_url( $term );
        
        $image_id  = get_term_meta( $term->term_id, 'image_id', true );
        $image     = aiovg_get_image_url( $image_id, 'large' );
        
        if ( $key % $attributes['columns'] == 0 ) echo '<div class="row">';
        ?>            
        <div class="<?php echo esc_attr( $class_column_container ); ?>">		
            <div class="thumbnail">
                <a href="<?php echo esc_url( $permalink ); ?>" class="aiovg-responsive-container" style="padding-bottom: <?php echo esc_attr( $attributes['ratio'] ); ?>;">
                    <img src="<?php echo esc_url( $image ); ?>" class="aiovg-responsive-element" />
                </a>
                
                <div class="caption">
                    <h3 class="aiovg-title">
                        <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $term->name ); ?></a>
                    </h3>
                        
                    <?php if ( ! empty( $attributes['show_description'] ) && $term->description ) : ?>
                    	<div class="aiovg-description"><?php echo esc_html( $term->description ); ?></div>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $attributes['show_count'] ) ) : ?>
                        <div class="aiovg-count">
                            <i class="fa fa-file-video-o" aria-hidden="true"></i> <?php printf( __( '%d videos', 'all-in-one-video-gallery' ), $term->count ); ?>
                        </div>
                    <?php endif; ?>
                </div>            			
            </div>			
        </div>                        
        <?php if ( 0 == ( $key + 1 ) % $attributes['columns'] || ( $key + 1 ) == count( $terms ) ) echo '</div>';        
    }
    ?>
</div>