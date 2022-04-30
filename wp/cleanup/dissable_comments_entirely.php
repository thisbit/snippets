<?php
/**
 * Remove all trace of comments on the site
 * @link https://keithgreer.uk/wordpress-code-completely-disable-comments-using-functions-php
 * @warning This is quite old, needs a checkup and update
 */


// First, this will disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		 if(post_type_supports($post_type, 'comments')) {
			 remove_post_type_support($post_type, 'comments');
			 remove_post_type_support($post_type, 'trackbacks');
		 }
	}
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Then close any comments open comments on the front-end just in case
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);

add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Finally, hide any existing comments that are on the site. 
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);