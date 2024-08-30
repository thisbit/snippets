<?php
/**
 * We set the $wp_meta_boxes array to empty when on dashboard, this will hide any and all dashboard items by core or 3rd party
 **/

function thisbit_remove_all_dashboard_widgets() {
	global $wp_meta_boxes;

	$wp_meta_boxes['dashboard'] = array();
}

add_action('wp_dashboard_setup', 'thisbit_remove_all_dashboard_widgets', 999 );