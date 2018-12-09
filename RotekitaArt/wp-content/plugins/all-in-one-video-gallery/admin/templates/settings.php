<?php

/**
 * Settings Form.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/admin/templates
 */
?>

<div id="aiovg-settings" class="wrap aiovg-settings">
    <h2 class="nav-tab-wrapper">
		<?php
		$settings_url = admin_url( 'edit.php?post_type=aiovg_videos&page=aiovg_settings' );
		
        foreach ( $this->tabs as $tab => $title ) {
            $class = ( $tab == $active_tab ) ? 'nav-tab nav-tab-active' : 'nav-tab';
            printf( '<a href="%s" class="%s">%s</a>', esc_url( add_query_arg( 'tab', $tab, $settings_url ) ), $class, $title );
        }
        ?>
    </h2>
    
	<?php settings_errors(); ?>
    
	<form method="post" action="options.php"> 
		<?php
        settings_fields( "aiovg_{$active_tab}_settings" );
        do_settings_sections( "aiovg_{$active_tab}_settings" );
        
        submit_button();
        ?>
    </form>
</div>