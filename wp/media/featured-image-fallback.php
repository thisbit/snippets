<?php

/**
 * Auto set featured images whenever there is no featured image set
 * I have not tested this
 */



function prefix_autoset_featured_image() {
  global $post;
  $already_has_thumb = has_post_thumbnail( $post->ID );
    if ( ! $already_has_thumb )  {
       set_post_thumbnail( $post->ID, '2023' ); // identified by attatchment ID
    }
}
add_action('the_post', 'prefix_autoset_featured_image');
add_action('save_post', 'prefix_autoset_featured_image');
add_action('draft_to_publish', 'prefix_autoset_featured_image');
add_action('new_to_publish', 'prefix_autoset_featured_image');
add_action('pending_to_publish', 'prefix_autoset_featured_image');
add_action('future_to_publish', 'prefix_autoset_featured_image');