<?php
function thisbit_add_svg_to_upload_mimes( $upload_mimes ) { 
	$upload_mimes['svg'] = 'image/svg+xml'; 
	$upload_mimes['svgz'] = 'image/svg+xml'; 
	return $upload_mimes; 
} 
add_filter( 'upload_mimes', 'thisbit_add_svg_to_upload_mimes', 10, 1 );