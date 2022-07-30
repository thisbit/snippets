<?php
/** 
 * Remove Gutenberg From Non Admins
 * For example, create custom fields to fill in, place them in gutenberg layout as shortcodes, then hide gutenberg from editors.
 * This way you can keep the layouts nice, and data will come in without messing up the layout
 * If you want stable templates, without the ability to modify from post to post 
 */

function thisbit_remove_post_type_support() {
    remove_post_type_support( 'post', 'editor' );
}

if( ! current_user_can('administrator') ) {
   // Hide gutenberg from others.
	add_action( 'init', 'thisbit_remove_post_type_support' );
}