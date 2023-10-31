<?php 
/**
 * Based on
 * @link https://www.billerickson.net/reusable-blocks-accessible-in-wordpress-admin-area
 * @link https://developer.wordpress.org/reference/functions/add_menu_page/
 * @param $page_title then $menu_title then $capability allowed to see, then $url slug, then $callback(optional), $icon, then $menu_position
 */


function thisbit_theming_blocks_admin_menu() {
	add_menu_page( __( 'Elements' ), __( 'Elements' ), 'customize', 'edit.php?post_type=gp_elements', '', 'dashicons-welcome-widgets-menus', 2 ); // gp elements
	add_menu_page( __( 'Local Templates' ), __( 'Local Templates' ), 'customize', 'edit.php?post_type=gblocks_templates', '', 'dashicons-schedule', 2 ); // gb local patterns
	add_menu_page( __( 'Synced Blocks' ), __( 'Synced Blocks' ), 'customize', 'edit.php?post_type=wp_block', '', 'dashicons-update', 2 ); // reusable blocks
}
add_action( 'admin_menu', 'thisbit_theming_blocks_admin_menu' );