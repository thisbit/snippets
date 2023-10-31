<?php

/**
 * Reorder GenerateBlocks Patterns (Local Templates) by title
 * So we can organize them more clearly
 */
function apuri_generateblocks_local_pattern_order( $wp_query ) {
  if ( is_admin() && !isset( $_GET['orderby'] ) ) {     
    // Get the post type from the query
    $post_type = $wp_query->query['post_type'];
    if ( in_array( $post_type, array('gblocks_templates') ) ) {
      $wp_query->set('orderby', 'title');
      $wp_query->set('order', 'ASC');
    }
  }
}
add_filter('pre_get_posts', 'apuri_generateblocks_local_pattern_order');