<?php
function my_theme_enqueue_styles() {
	$parant_style = 'shop-isle-style';
	
	wp_enqueue_style( $parant_style, get_template_directory_uri().'/style.css' );
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri().'/style.css',
		array($parant_style),
		wp_get_theme()->get('Version')
	);
}
add_action ('wp_enqueue_scripts', 'my_theme_enqueue_styles' );
?>