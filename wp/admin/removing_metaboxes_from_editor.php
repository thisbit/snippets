<?php 

function remove_meta_boxes() {
  # Removes meta from Posts #
  remove_meta_box('postexcerpt','post','normal' ); 
  remove_meta_box('postcustom','post','normal');
  remove_meta_box('trackbacksdiv','post','normal');
  remove_meta_box('commentstatusdiv','post','normal');
  remove_meta_box('commentsdiv','post','normal');
  remove_meta_box('formatdiv','post','normal');

  # Removes meta from pages #
  remove_meta_box('postexcerpt','page','normal'); // optionally use this if page excerpts are enabled
  remove_meta_box('postcustom','page','normal');
  remove_meta_box('trackbacksdiv','page','normal');
  remove_meta_box('commentstatusdiv','page','normal');
  remove_meta_box('commentsdiv','page','normal');
}
add_action('admin_init','remove_meta_boxes');

/* Single metabox */
function remove_default_excerpt_metabox() {
	remove_meta_box( 'postexcerpt','post','normal' ); 
}
add_action('admin_menu','remove_excerpt_metabox');