<?php 
/**
 * Rename Default Menu Items
 * Example with posts. 
 */

// Rename posts in the admin menu
function thisbit_update_post_label() {
   global $menu;
   global $submenu;
   $submenu['edit.php'][5][0] = 'Story';
   $submenu['edit.php'][10][0] = 'Add Story';
   $submenu['edit.php'][16][0] = 'Story Tags';
   $menu[5][0] = 'Stories';
}
add_action( 'admin_menu', 'thisbit_update_post_label' );

// Rename the buttons/labels in the Post section
function thisbit_update_post_name() {
   global $wp_post_types;
   $labels = &$wp_post_types['post']->labels;
   $labels->name = 'Stories';
   $labels->singular_name = 'Story';
   $labels->add_new = 'Add Story';
   $labels->add_new_item = 'Add Story';
   $labels->edit_item = 'Edit Story';
   $labels->new_item = 'Story';
   $labels->view_item = 'View Story';
   $labels->search_items = 'Search Story';
   $labels->not_found = 'No Stories found';
   $labels->not_found_in_trash = 'No Stories found in Trash';
   $labels->all_items = 'All Stories';
   $labels->menu_name = 'Stories';
   $labels->name_admin_bar = 'Stories';
}
add_action( 'admin_init', 'thisbit_update_post_name' );