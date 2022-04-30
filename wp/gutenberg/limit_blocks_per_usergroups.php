<?php

/**
 * Limit user access to blocks we actually use.
 */
function prefix_allowed_block_types_per_usergroup() {
	
	$user = wp_get_current_user(); // if used in theme
	$limit_roles = array(
		'contributor',
		'author',
		'editor'
	);

  if ( array_intersect( $limit_roles, $user->roles ) ) {
    return array(
      'core/paragraph',
      
    );
  }
	return array(
		'core/paragraph'
	);
}
add_filter( 'allowed_block_types_all', 'prefix_allowed_block_types_per_usergroup' );