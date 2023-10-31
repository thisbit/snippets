<?php
/**
 * Limit block access based on post types
 */
function apuri_allowed_block_types_per_postype( $allowed_blocks, $post ) {
	if ( current_user_can( 'customize' ) ) { // Admin can do all
		return array(
			'generateblocks/template-library',
			'generateblocks/container',
			'generateblocks/grid',
			'generateblocks/query-loop',
			'generateblocks/button',
			'generateblocks/button-container',
			'generateblocks/headline',
			'generateblocks/image',
			'generatepress/dynamic-content',
			'generatepress/dynamic-image',
			'acf/slider',
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/list-item',
			'core/image',
			'core/gallery',
			'core/quote',
			'core/embed',
			'core/html',
			'core/block',
			'core/shortcode',
			'core/table',
			'core/search',
		);
	} else { // non admins can basic and Local Patterns, have to remove settings too
		return array(
			'generateblocks/template-library',
			'generateblocks/container',
			'generateblocks/grid',
			'generateblocks/button',
			'generateblocks/query-loop',
			'generateblocks/button-container',
			'generateblocks/headline',
			'generateblocks/image',
			'acf/slider',
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/list-item',
			'core/quote',
			'core/embed',
			'core/block',
			'core/table',
		);
	}
}
add_filter( 'allowed_block_types_all', 'apuri_allowed_block_types_per_postype', 10, 2 );
