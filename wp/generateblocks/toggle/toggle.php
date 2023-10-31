<?php
function thisbit_toggle_for_generateblocks() {
	global $post;
	$blocks = parse_blocks( $post->post_content );
	foreach( $blocks as $block ) {
		$block['attrs']['className'] = ""; // initiate className to fix error reporting index undefined
		if( $block['attrs']['className'] && $block['attrs']['className'] !== 'toggle' ) { return;
		} else {
			wp_enqueue_style( 'thisbit-toggle', get_stylesheet_directory_uri() . '/assets/css/toggle.css', false, '0.0.1', 'all');
			wp_enqueue_script( 'thisbit-toggle', get_stylesheet_directory_uri() . '/assets/js/toggle.js', '', '0.0.1', true );
			return;
		}
	}
}
add_action( 'wp_enqueue_scripts', 'thisbit_toggle_for_generateblocks', 9999 );


function thisbit_toggle_for_generateblocks_admin() {
	wp_enqueue_style( 'thisbit-toggle', get_stylesheet_directory_uri() . '/assets/css/toggle.css', false, '0.0.1', 'all');
}
add_action( 'enqueue_block_assets', 'thisbit_toggle_for_generateblocks_admin', 9999 );