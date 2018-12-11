<?php
function my_theme_enqueue_styles() {
	$parant_style = 'astra-style';
	
	wp_enqueue_style( $parant_style, get_template_directory_uri().'/style.css' );
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri().'/style.css',
		array($parant_style),
		wp_get_theme()->get('Version')
	);
}

add_action ('wp_enqueue_scripts', 'my_theme_enqueue_styles' );

add_action( 'admin_init', 'disable_autosave' );

function disable_autosave() {
        wp_deregister_script( 'autosave' );
}

?>

<?php
function myshortcode_breadcrumb( ){
	if ( function_exists('yoast_breadcrumb') ) {
	  return yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
}
add_shortcode( 'site_breadcrumb', 'myshortcode_breadcrumb' );
?>

<?php
function mymailchimp_signup_form() {
	$html_code = "<!-- Begin Mailchimp Signup Form -->
	<link href='//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css' rel='stylesheet' type='text/css'>
	<script type='text/javascript' src='//downloads.mailchimp.com/js/signup-forms/popup/unique-methods/embed.js'
	data-dojo-config='usePlainJson: true, isDebug: false'></script>
	<!-- Begin mc_embed_signup -->
	<script type='text/javascript'>window.dojoRequire(['mojo/signup-forms/Loader'], 
	function(L) { L.start({'baseUrl':'mc.us19.list-manage.com','uuid':'504af2eaad33945776db7eaf7','lid':'71b1ed015b','uniqueMethods':true}) })</script>
	<!-- End mc_embed_signup -->
	<!-- End Mailchimp Signup Form -->";

	return $html_code; 
}
add_shortcode( 'mailchimp_signup_form', 'mymailchimp_signup_form' );

function mymailchimp_registration_form() {
	$html_code = "<!-- Begin Mailchimp Signup Form -->
	<div id='mc_embed_signup'>
	<form action='https://RotekitaArt.us19.list-manage.com/subscribe/post?u=504af2eaad33945776db7eaf7&amp;id=71b1ed015b' method='post' id='mc-embedded-subscribe-form' name='mc-embedded-subscribe-form' class='validate' target='_blank' novalidate>
		<div id='mc_embed_signup_scroll'>
		<label for='mce-EMAIL'>Join our members club!</label>
		<input type='email' value='' name='EMAIL' class='email' id='mce-EMAIL' placeholder='email address' required>
		<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
		<div style='position: absolute; left: -5000px;' aria-hidden='true'><input type='text' name='b_504af2eaad33945776db7eaf7_71b1ed015b' tabindex='-1' value=''></div>
		<div class='clear'><input type='submit' value='Subscribe' name='subscribe' id='mc-embedded-subscribe' class='button'></div>
		</div>
	</form>
	</div>
	<!--End mc_embed_signup-->";
	
	return $html_code; 
}
add_shortcode( 'mailchimp_registration_form', 'mymailchimp_registration_form' );
?>

<?php
function myshortcode_featured_image( ){
    global $post;
	if( is_single() ) {
		$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
		// return it as an CSS property.
		$backgroundImage = "background-image: url('" . $url[0] . "');";
	}
	return $backgroundImage;
}
add_shortcode( 'post_featured_image', 'myshortcode_featured_image' );

function myshortcode_styled_featured_image( ){
	if( is_single() ) {	
		$my_featured_image_shortcode = myshortcode_featured_image( );
		$my_featured_image = '<div class="my-post-thumbnail" style=' . '"' . $my_featured_image_shortcode . '"' . '></div>';
	}
    return $my_featured_image;
}
add_shortcode( 'post_styled_featured_image', 'myshortcode_styled_featured_image' );
?>

<?php
//add_action( 'woocommerce_before_main_content', 'additional_div_in_woocommerce', 5 );
function additional_div_in_woocommerce() {
    // Only on "shop" archives pages
    if( ! (is_woocommerce() || is_filtered()) ) return; 

    // Output the div
    ?>
        <div><?php echo do_shortcode('[searchandfilter id="primary_product_filter"]'); ?></div>
    <?php
}
add_shortcode( 'woocommerce_product_filter', 'additional_div_in_woocommerce' );
?>

<?php
function additional_woof_div_in_woocommerce() {
    // Only on "shop" archives pages
    if( ! (is_woocommerce() || is_filtered()) ) return; 

    // Output the div
    ?>
        <div><?php echo do_shortcode('[woof sid="auto_shortcode" autohide=1]'); echo do_shortcode('[woof_products per_page=8 columns=3 is_ajax=1]'); ?></div>
    <?php
}
add_shortcode( 'woof_product_filter', 'additional_woof_div_in_woocommerce' );
?>

<?php
function myshortcode_title( ){
   return get_the_title();
}
add_shortcode( 'post_title', 'myshortcode_title' );

function myshortcode_permalink( ){
	global $post;
	return $post->post_permalink;
}
add_shortcode( 'post_permalink', 'myshortcode_permalink' );

function myshortcode_modified_time( ){
	global $post;
	return "Last Updated On " . $post->post_modified . ", By " . get_the_author();
/*	
	$date_obj = get_the_modified_time('d\/m\/Y G:i', $post->ID);
*/	
}
add_shortcode( 'post_modified_time', 'myshortcode_modified_time' );

function myshortcode_excerpt( ){
	global $post;
	return $post->post_excerpt;
}

add_shortcode( 'post_excerpt', 'myshortcode_excerpt' );

?>