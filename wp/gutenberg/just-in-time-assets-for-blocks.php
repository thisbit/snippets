<?php
/*
Plugin Name: Just in Time CSS
Plugin URI: https://highrise.digital/
Description: A plugin from Highrise Digital to provide just in time CSS functionality.
Version: 1.0
License: GPL-2.0+
Author: Highrise Digital Ltd
Author URI: https://highrise.digital/
Text domain: hd-just-in-time-css
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* exist if directly accessed */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// define variable for path to this plugin file.
define( 'HD_JITCSS_LOCATION', dirname( __FILE__ ) );
define( 'HD_JITCSS_LOCATION_URL', plugins_url( '', __FILE__ ) );

/**
 * Function to run on plugins load.
 */
function hd_jitcss_plugins_loaded() {

	$locale = apply_filters( 'plugin_locale', get_locale(), 'hd-just-in-time-css' );
	load_textdomain( 'hd-just-in-time-css', WP_LANG_DIR . '/hd-just-in-time-css/hd-just-in-time-css-' . $locale . '.mo' );
	load_plugin_textdomain( 'hd-just-in-time-css', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

}

add_action( 'plugins_loaded', 'hd_jitcss_plugins_loaded' );

/**
 * Register the block styles for each registered or supported block.
 */
function hd_jitcss_register_block_styles() {

	// if we don't have a list of supported blocks.
	if ( ! function_exists( 'hd_get_supported_blocks' ) ) {
		return;
	}

	// get me all the registered blocks.
	$blocks = hd_get_supported_blocks();

	// if we have registered blocks.
	if ( ! empty( $blocks ) ) {

		// loop through each block.
		foreach ( $blocks as $block ) {

			// default block name and css file location.
			$block_base = '';
			$block_name = '';
			$css_file_location = '';
			
			// make the core block names, filename friendly.
			if ( strpos( $block, 'core/' ) !== false) {

				// set the block base to core.
				$block_base = 'core';

				// remove the core from the block name.
				$block_name = str_replace( 'core/', '', $block );

				// set the path to the folder for block css files.
				$css_file_path = 'assets/css/05-blocks/core/' . $block_name . '/' . $block_name . '.css';

			}

			// make the custom block names, filename friendly.
			elseif ( strpos( $block, 'acf/' ) !== false) {

				// set the block base to acf.
				$block_base = 'acf';
				
				// remove the acf from the block name.
				$block_name = str_replace( 'acf/', '', $block );

				// set the path to the folder for block css files.
				$css_file_path = 'assets/css/05-blocks/custom/' . $block_name . '/' . $block_name . '.css';

			}

			else {

				// split the block name via the forward slash.
				$block_name = explode( '/', $block );

				// set the block base.
				$block_base = $block_name[0];

				// set the block name.
				$block_name = $block_name[1];

				// set the path to the folder for block css files.
				$css_file_path = 'assets/css/05-blocks/3rd-party/' . $block_base . '/' . $block_name . '.css';

			}

			// if block name was generated.
			if ( '' !== $block_name ) {

				// build the file location.
				$css_file_location = locate_template( $css_file_path );

				// if this css file exists for this block.
				if ( '' !== $css_file_location ) {

					// create and allow devs to filter the URL of a block stylesheet.
					$block_css_url = apply_filters(
						'hd_theme_block_css_url',
						trailingslashit( get_stylesheet_directory_uri() ) . $css_file_path,
						$block
					);

					// register the style for this block.
					wp_register_style(
						'hd-' . $block_name,
						$block_css_url
					);

				}

			}

		}

	}

}

add_action( 'wp_head', 'hd_jitcss_register_block_styles' );

/**
 * Prints the block styles for each block.
 *
 * @param  string $content The block content about to be appended.
 * @param  array  $block   The current array of block data including names and attributes.
 *
 * @return string $content The new block content string
 */
function hd_jitcss_print_block_styles( $content, $block ) {

	// if we have a block name.
	if ( ! empty( $block['blockName'] ) ) {

		// default block name.
		$block_name = '';
		$block_base = '';

		// make the core block names, filename friendly.
		if ( strpos( $block['blockName'], 'core/' ) !== false) {

			// set the block base to core.
			$block_base = 'core';

			// remove the core from the block name.
			$block_name = str_replace( 'core/', '', $block['blockName'] );

		}

		// make the custom block names, filename friendly.
		elseif ( strpos( $block['blockName'], 'acf/' ) !== false) {

			// set the block base to acf.
			$block_base = 'acf';
			
			// remove the acf from the block name.
			$block_name = str_replace( 'acf/', '', $block['blockName'] );

		} else {

			// split the block name via the forward slash.
			$block_name = explode( '/', $block['blockName'] );
			
			// set the block base.
			$block_base = $block_name[0];
			$block_name = $block_name[1];

		}

		// if we have a block name.
		if ( '' !== $block_name ) {

			// start output buffering to print the block styles.
			ob_start();

			// print the styles registered for this block.
			wp_print_styles( 'hd-' . $block_name );

			// add the printed styles to the start of the block content.
			$content = ob_get_clean() . $content;

		}

	}

	// return the block content.
	return $content;

}

add_filter( 'render_block', 'hd_jitcss_print_block_styles', 10, 2 );

/**
 * Loads stylesheets for template if a stylesheet name is passed as args.
 * Part of the just in time CSS implementation.
 *
 * @param string $slug     The slug name for the generic template.
 * @param string $name     The slug name for the generic template.
 * @param array  $template Array of template files to search for, in order.
 * @param array	 $args     Additional arguments passed to the template
 * 
 */
function hd_jitcss_load_template_stylesheets( $slug, $name, $template, $args ) {

	// if we have a stylesheet to load.
	if ( ! empty( $args['stylesheet_name'] ) ) {
		
		// set a default stylesheet path.
		$stylesheet_path = 'assets/css/06-components';

		// if we have a stylesheet path set.
		if ( ! empty( $args['stylesheet_path'] ) ) {

			// set the stylesheet path.
			$stylesheet_path = $args['stylesheet_path'];

		}
		
		// build the css file path.
		$css_file_path = trailingslashit( $stylesheet_path ) . trailingslashit( $args['stylesheet_name'] ) . $args['stylesheet_name'] . '.css';

		// locate this css file in the theme structure.
		$css_file_location = locate_template( $css_file_path );

		// if we have a CSS file.
		if ( '' !== $css_file_location ) {

			// build the stylesheet name.
			$stylesheet_name = $args['stylesheet_name'];

			// if we have a name after the slug.
			if ( ! empty( $name ) ) {

				// add this to the stylesheet name.
				$stylesheet_name .= '-' . $name;

			}

			// register this style in WP.
			wp_register_style(
				$stylesheet_name,
				trailingslashit( get_template_directory_uri() ) . $css_file_path,
				array(),
				false,
				'all'
			);

			// print the stylesheet.
			wp_print_styles( $stylesheet_name );

		}
	
	}

}

add_action( 'get_template_part', 'hd_jitcss_load_template_stylesheets', 10, 4 );

/**
 * Output a just in time css stylesheet link.
 *
 * @param string $filename The name of the CSS file to load without the extension.
 * @param string $path     The path to the file in the root theme folder.
 *
 * @return string mixed    Either an empty string or the link to the stylesheet.
 */
function hd_jitcss_output_just_in_time_css( $filename, $path = 'assets/css/' ) {

	// build url to stylesheet.
	$stylesheet_url = get_stylesheet_directory_uri() . '/' . trailingslashit( $path ) . $filename . '.css';

	// locate this css file in the theme structure.
	$stylesheet_file_location = locate_template( trailingslashit( $path ) . $filename . '.css' );

	// if we have a CSS file.
	if ( '' !== $stylesheet_file_location ) {

		// register the style in WP.
		wp_register_style(
			$filename,
			$stylesheet_url,
			array(),
			false,
			'all'
		);

		// print the stylesheet.
		wp_print_styles( $filename );

	}
	
}