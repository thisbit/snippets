<?php

function my_max_image_size( $file ) {
  $size = $file['size'];
  $size = $size / 1024;
  $type = $file['type'];
  $is_image = strpos( $type, 'image' ) !== false;
  $limit = 750;
  $limit_output = '750kb';
  if ( $is_image && $size > $limit ) {
    $file['error'] = 'Image files must be smaller than ' . $limit_output;
  }
  return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'my_max_image_size' );
