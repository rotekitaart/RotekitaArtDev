<?php

/**
 * Search form, horizontal layout.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/public/templates
 */
?>

<div class="aiovg aiovg-search-form aiovg-form-horizontal">

	<form method="get" action="<?php echo esc_url( aiovg_get_search_page_url() ); ?>">
    	<?php if ( ! get_option('permalink_structure') ) : ?>
       		<input type="hidden" name="page_id" value="<?php echo esc_attr( $attributes['search_page_id'] ); ?>" />
    	<?php endif; ?>	
        
        <?php if ( $attributes['has_category'] ) : ?>
        
            <div class="form-inline">            
                <div class="aiovg-field-keyword form-group">
                    <input type="text" name="vi" class="form-control" placeholder="<?php esc_attr_e( 'Search by title', 'all-in-one-video-gallery' ); ?>" value="<?php echo isset( $_GET['vi'] ) ? esc_attr( $_GET['vi'] ) : ''; ?>" />
                </div>
                
                <div class="aiovg-field-category form-group">
                	<?php
        			wp_dropdown_categories( array(
            			'show_option_none'  => '-- ' . __( 'Select a Category', 'all-in-one-video-gallery' ) . ' --',
						'option_none_value' => '',
            			'taxonomy'          => 'aiovg_categories',
            			'name' 			    => 'ca',
						'class'             => 'form-control',
            			'orderby'           => 'name',
						'selected'          => isset( $_GET['ca'] ) ? (int) $_GET['ca'] : '',
            			'hierarchical'      => true,
            			'depth'             => 10,
            			'show_count'        => false,
            			'hide_empty'        => false,
        			) );
					?>
                </div>
                
                <input type="submit" class="btn btn-primary" value="<?php _e( 'Search', 'all-in-one-video-gallery' ) ?>" />
                
                <?php if ( ! empty( $attributes['search_query'] ) ) : ?>
                	<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-default"><?php _e( 'Reset', 'all-in-one-video-gallery' ); ?></a> 
                <?php endif; ?>            
            </div>
        
        <?php else : ?> 
        
            <div class="input-group">
                <input type="text" name="vi" class="form-control" placeholder="<?php esc_attr_e( 'Search by title', 'all-in-one-video-gallery' ); ?>" value="<?php echo isset( $_GET['vi'] ) ? esc_attr( $_GET['vi'] ) : ''; ?>" />
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                    <?php if ( ! empty( $attributes['search_query'] ) ) : ?>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <?php endif; ?>
                </span>
            </div>
        
    	<?php endif; ?>
	</form>
 
</div>
