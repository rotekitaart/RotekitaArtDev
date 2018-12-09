<?php

/**
 * Shortcode Builder.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/admin/templates
 */
?>

<div id="aiovg-shortcode-builder" class="aiovg-shortcode-builder mfp-hide">

    <div id="aiovg-shortcode" class="aiovg-shortcode">
        <p><?php echo __( 'Use the form below to insert "All-in-One Video Gallery" plugin shortcodes.', 'all-in-one-video-gallery' ); ?></p>
        
        <!-- Shortcodes -->
        <div class="aiovg-shortcode-selector">
        	<label for="aiovg-shortcode-type"><strong><?php echo __( 'Shortcode Type', 'all-in-one-video-gallery' ); ?></strong></label> 
            <select id="aiovg-shortcode-type" class="widefat">
            	<?php
				foreach ( $shortcodes as $value => $label ) {
					printf( '<option value="%s">%s</option>', $value, $label );
				}
				?>
       		</select>
        </div>  
        
        <!-- Fields -->
        <?php
        foreach ( $shortcodes as $shortcode => $label ) :

			foreach( $fields[ $shortcode ] as $field ) : 
				$field_id = "aiovg-shortcode-{$shortcode}-{$field['name']}";		
				?>
            	<div class="aiovg-shortcode-field aiovg-shortcode-type-<?php echo $shortcode; ?>"> 	
 
					<?php if( 'html' == $field['type'] ) : ?>
                    
                        <label class="aiovg-shortcode-label"><strong><?php echo wp_kses_post( $field['label'] ); ?></strong></label>
                        
                    <?php elseif ( 'category' == $field['type'] ) : ?>
                        
                        <label class="aiovg-shortcode-label" for="<?php echo esc_attr( $field_id ); ?>"><strong><?php echo esc_html( $field['label'] ); ?></strong></label>
                        <?php
						wp_dropdown_categories( array(
							'show_option_none'  => '-- '.__( 'Top Categories', 'all-in-one-video-gallery' ).' --',
							'option_none_value' => 0,
							'taxonomy'          => 'aiovg_categories',
							'name' 			    => $field_id,
							'class'             => 'aiovg-shortcode-input widefat',
							'orderby'           => 'name',
							'hierarchical'      => true,
							'depth'             => 10,
							'show_count'        => false,
							'hide_empty'        => false,
						) );
						?>
                        
                    <?php elseif ( 'categories' == $field['type'] ) : ?>
                        
                        <label class="aiovg-shortcode-label" for="<?php echo esc_attr( $field_id ); ?>"><strong><?php echo esc_html( $field['label'] ); ?></strong></label>
                        <ul id="<?php echo esc_attr( $field_id ); ?>" class="aiovg-shortcode-input aiovg-checklist widefat" data-default="<?php echo esc_attr( $field['default'] ); ?>">
                            <?php
                            $args = array(
                            'taxonomy'      => 'aiovg_categories',
                            'walker'        => null,
                            'checked_ontop' => false
                            ); 
                        
                            wp_terms_checklist( 0, $args );
                            ?>
                        </ul>
                        
                    <?php elseif ( 'text' == $field['type'] ) : ?>
                    
                        <label class="aiovg-shortcode-label" for="<?php echo esc_attr( $field_id ); ?>"><strong><?php echo esc_html( $field['label'] ); ?></strong></label>
                        <input type="text" id="<?php echo esc_attr( $field_id ); ?>" class="aiovg-shortcode-input widefat" value="<?php echo esc_attr( $field['value'] ); ?>" data-default="<?php echo esc_attr( $field['default'] ); ?>" />
                        
                    <?php elseif ( 'select' == $field['type'] ) : ?>
                        
                        <label class="aiovg-shortcode-label" for="<?php echo esc_attr( $field_id ); ?>"><strong><?php echo esc_html( $field['label'] ); ?></strong></label> 
                        <select id="<?php echo esc_attr( $field_id ); ?>" class="aiovg-shortcode-input widefat" data-default="<?php echo esc_attr( $field['default'] ); ?>">
                            <?php
                            foreach ( $field['options'] as $value => $label ) {
                                printf( '<option value="%s"%s>%s</option>', esc_attr( $value ), selected( $value, $field['value'], false ), esc_html( $label ) );
                            }
                            ?>
                        </select>
                    
                    <?php elseif ( 'checkbox' == $field['type'] ) : ?>
                    
                        <label class="aiovg-shortcode-label" for="<?php echo esc_attr( $field_id ); ?>">				
                            <input type="checkbox" id="<?php echo esc_attr( $field_id ); ?>" class="aiovg-shortcode-input" data-default="<?php echo esc_attr( $field['default'] ); ?>" value="1" <?php checked( $field['value'] ); ?> />
                            <?php echo esc_html( $field['label'] ); ?>
                        </label>
                        
                    <?php elseif ( 'color' == $field['type'] ) : ?>
                    
                        <label class="aiovg-shortcode-label" for="<?php echo esc_attr( $field_id ); ?>"><strong><?php echo esc_html( $field['label'] ); ?></strong></label>
                        <input type="text" id="<?php echo esc_attr( $field_id ); ?>" class="aiovg-shortcode-input aiovg-color-picker-field widefat" value="<?php echo esc_attr( $field['value'] ); ?>" data-default="<?php echo esc_attr( $field['default'] ); ?>" />
                    
                    <?php endif; ?>
                                        
                </div>    
            	<?php
          	endforeach;
            
       	endforeach;
		?>      
        
        <!-- Action Buttons -->
        <p class="submit">
            <input type="button" id="aiovg-insert-shortcode" class="button-primary" value="<?php echo __( 'Insert Shortcode', 'all-in-one-video-gallery' ); ?>" />
            <a id="aiovg-cancel-shortcode-insert" class="button-secondary"><?php _e( 'Cancel', 'all-in-one-video-gallery' ); ?></a>
        </p>        
               
    </div>
    
</div>