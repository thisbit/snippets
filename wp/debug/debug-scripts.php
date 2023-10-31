<?php
/*
	Get Script and Style IDs
	Adds inline comment to your frontend pages
	View source code near the <head> section
	Lists only properly registered scripts
	@ https://digwp.com/2018/08/disable-script-style-added-plugins/
*/
function shapeSpace_inspect_script_style() {
	
	global $wp_scripts, $wp_styles;
	
	echo "\n" .'<!--'. "\n\n";
	
	echo 'SCRIPT IDs:'. "\n";
	
	foreach($wp_scripts->queue as $handle) echo $handle . "\n";
	
	echo "\n" .'STYLE IDs:'. "\n";
	
	foreach($wp_styles->queue as $handle) echo $handle . "\n";
	
	echo "\n" .'-->'. "\n\n";
	
}
add_action('wp_print_scripts', 'shapeSpace_inspect_script_style');