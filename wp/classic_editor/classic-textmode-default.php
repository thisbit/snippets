<?php 
/**
 * Set the Classic Editor to text mode based on post type
 * Has to be allready set to classic mode
 */
function change_wp_default_editor() {
	if ( get_post_type() === 'cpt-slug' ) {
		return 'html';
	}
}
add_filter( 'wp_default_editor', 'change_wp_default_editor' );