<?php
/**
 * For previewing active image sizes
 */

function cdxn_get_image_sizes() {
	global $_wp_additional_image_sizes;
	$sizes = array();
	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
			'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
			'height' => $_wp_additional_image_sizes[ $_size ]['height'],
			'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}
	return $sizes;
}
$get_thumbnails = cdxn_get_image_sizes();
// print out all the image sizes	
echo '<pre>';
print_r($get_thumbnails);
echo '</pre>';
