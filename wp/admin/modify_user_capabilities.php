<?php
/**
* Add or remove capabilities from user roles
*/

function thisbit_modify_role_caps() {
	// Get roles
	$author = get_role( 'author' );
	$editor = get_role( 'editor' );

	// remove the capability to edit pages from editors
	$editor->remove_cap( 'edit_pages' );

	// add the capability to edit pages for authors
	$editor->add_cap( 'edit_pages' );
}
add_filter( 'init', 'thisbit_modify_role_caps');