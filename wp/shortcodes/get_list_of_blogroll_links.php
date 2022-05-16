<?php
/** 
 * This enables simple links management sing default WP manager and a shortcode to display links from some category
 */


// Default wordpress link manager is not enabled by default, so enable it
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

/**
 * List links from category with shortcode
 * @param shortcode [apuri_links cat=catname]
 */
function apuri_links_listing( $atts ) {

	ob_start();
	$cat = [];

	// Attributes for the shortcode
	$atts = shortcode_atts( 
		array(
			'cat' => $cat,     // specify category term name
		), 
	$atts );

	$cat = $atts[ 'cat' ];

	$args = array(
		'category_name' => $cat,
		"hide_empty"    => true,
		'orderby'       => 'title',
		'order'         => 'ASC',
	);

	echo wp_list_bookmarks( $args );

	return ob_get_clean();
}
add_shortcode( 'apuri_links', 'apuri_links_listing' );

