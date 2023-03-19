<?php 
/*
Plugin Name:  Custom Block Pattern Builder
Description:  Plugin enables visual creation of block patterns in a dedicated CPT
Author:       Name Lastname
Author URi:   https://sitename.domain
Version:      1.0.0
Text Domain:  
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
*/


// SECURITY exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} else if ( ! defined( 'WPINC' ) ) {
		die;
}

/**
 * Gutenberg Block Pattern Builder
 * Based of of Custom Block Patterns, but simplified
 * @link https://wordpress.org/plugins/custom-block-patterns/
 */

function register_block_patterns() {

	if ( ! is_admin() ) return;
		register_block_pattern_category( 'block_patterns_category', 
		[
			'label' => _x( 'Prefix Quick Layouts', 'apuri' ),
		] );
	
		$the_query = new WP_Query( [
			'post_type'              => 'block_patterns',
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		] );
	
		foreach ( $the_query->posts as $pattern ) :
			$post_ID     = $pattern->ID;
			$properties  = [
				'title'      => $pattern->post_title,
				'content'    => $pattern->post_content,
				'categories' => [ 'block_patterns_category' ],
			];
	
			$block_types = apply_filters( 'custom_block_types', [], $post_ID );
	
			if ( ! empty( $block_types ) ) :
				$properties['blockTypes'] = $block_types;
			endif;
	
			register_block_pattern( 'block_patterns_category/pattern-' . $post_ID, $properties );
		endforeach;
		wp_reset_postdata();
	}
add_action( 'init', 'register_block_patterns', 20 );
	
	
/**
 * Register patterns as post types
 */
	function register_custom_patterns_post_type() {
		$pattern_name = __( 'Block Patterns', 'block_patterns' );
		register_post_type(
			'block_patterns',
			[
				'labels'        => [
					'name'          => $pattern_name,
					'singular_name' => $pattern_name,
				],
				'public'        => false,
				'menu_position' => 20,
				'show_ui'       => true,
				'show_in_menu'  => true,
				//'capabilities'  => 'customize',
				'map_meta_cap'  => true,
				'has_archive'   => true,
				'menu_icon'     => 'dashicons-screenoptions',
				'show_in_rest'  => true,
				'supports'      => [ 'title', 'editor' ]
			]
		);
	}
add_action( 'init', 'register_custom_patterns_post_type', 11 );

// Unregister WordPress Core default block patterns
function remove_patterns() {
	remove_theme_support( 'core-block-patterns' );
}
//add_action( 'after_setup_theme', 'remove_patterns' );


/**
* Bugfix for handling pattern control in gutenberg
* If one removes default patterns, then adds custom ones, the default ones come back
* @link https://generatepress.com/forums/topic/remove-core-patterns/#post-1668343
*/
function register_block_patterns_bugfix()
 {
	 if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {
		 // register a placeholder default pattern
		 register_block_pattern( 'apuri/Horizontalna-linija', 
		 [
			 'title' => __('Horizontalna linija', 'apuri'),
			 'description' => _x(
				 'Default block pattern',
				 'This is Classic Editor',
				 'apuri'
			 ),
			 'content' => 
			 "<!-- wp:paragraph -->\n<p>Ovo ne koristiti, tu je samo kao bug fix.</p>\n<!-- /wp:paragraph -->",
			 'categories' => [''],
		 ]);

		 // register placeholder category
		 register_block_pattern_category('za_bugfix_pattern', 
		 [
			 'label' => _x('Ignore sekcija', 'apuri'),
		 ]);
	 }
 }

add_action( 'init', 'register_block_patterns_bugfix' );


// Remove patterns post type from db

if( ! function_exists( 'unregister_post_type' ) ) {
	function plugin_unregister_post_type(){
			unregister_post_type( 'block_patterns' );
	}
}

// add_action('init','unregister_post_type'); // run this if you intend to stop using the plugin



// List all registered post types 
function apuri_debug_list_post_types() {
	$post_types = get_post_types( '', 'names' ); 
 
	echo '<pre style="min-height: 720px;">';
	echo '<h4>Registered Post Types</h4>';
			
	foreach ( $post_types as $post_type ) {
		echo $post_type . '<br>' ; 
	}
	
	echo '</pre>';
}

add_action( 'wp_head', 'apuri_debug_list_post_types' );
