<?php
/**
 * Remove textmode in Classic Editor text mode
 */
function my_editor_settings($settings) {
	$settings['quicktags'] = false;
	return $settings;
	}
	
add_filter('wp_editor_settings', 'my_editor_settings');