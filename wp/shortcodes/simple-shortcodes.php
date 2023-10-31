<?php

// Site URL Shortcode

function apuri_site_url() {
	$siteurl = get_site_url();
	return $siteurl;
}
 //add_shortcode('siteurl','apuri_site_url');

// Site title shortcode
function apuri_site_title_shortcode() {
		return get_bloginfo( 'name' );
}
add_shortcode( 'apuri_title','apuri_site_title_shortcode' );

// Site tagline shortcode
function apuri_site_description_shortcode() {
	return get_bloginfo( 'description' );
}
add_shortcode( 'uniri_title','apuri_site_description_shortcode' );

//Current Year Shortcode
function apuri_year_shortcode() {
	$year = date('Y');
	return $year;
}
add_shortcode('year', 'apuri_year_shortcode');


//Anti-Spam Email Shortcode
//Use this shortcode [email]nathan@ithemes.com[/email]

function apuri_protect_email_address( $atts , $content=null ) {
   $encodedmail = '';
   for ($i = 0; $i < strlen($content); $i++) $encodedmail .= "&#" . ord($content[$i]) . ';';
   return '<a href="mailto:'.$encodedmail.'">'.$encodedmail.'</a>';
}
add_shortcode('email', 'apuri_protect_email_address');

/**
 * Print post type singular name using the schortcode
 * Has to be used within the loop
 */
if ( ! function_exists( 'apuri_print_post_type' ) ) {
	function apuri_print_post_type() {
		ob_start();

		$post_type = get_post_type_object( get_post_type() );
		if ( $post_type ) {
				return esc_html( $post_type->labels->singular_name );
		}
		return ob_get_clean();
	}
}
add_shortcode( 'apuri_post_type', 'apuri_print_post_type' );