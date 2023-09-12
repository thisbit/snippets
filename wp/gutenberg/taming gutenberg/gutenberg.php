<?php
/**
 * Gutenberg Block customization for this theme.
 */
// gutenberg disable for posts
//add_filter('use_block_editor_for_post', '__return_false', 10);

// gutenberg disable for post types
//add_filter('use_block_editor_for_post_type', '__return_false', 10);

/**
 *Disable gutenberg stylesheets in frontend; requires creating custom styles for allowed core blocks
 **/
function jjm_deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_print_styles', 'jjm_deregister_styles', 100 );

/**
 * Customize core block functionality
 */
function jjm_2022_block_setup() {
	// Sometimes you disable block functionality by adding theme support...
	add_theme_support( 'disable-custom-colors' ); // User-defined colors
	add_theme_support( 'disable-custom-gradients' ); // User-defined gradient
	add_theme_support( 'disable-custom-font-sizes' ); // User-defined font sizes
	add_theme_support('editor-font-sizes', array( // Define our own allowed font sizes here
        	array(
            		'name' => 'Normal',
            		'size' => 20,
            		'slug' => 'normal'
        	)
    	) );
	
    	// And sometimes by removing theme support...
    	remove_theme_support( 'block-templates' ); // Allows user to create their own templates from within the editor
	remove_theme_support( 'core-block-patterns' ); // Allows user to create their own block patterns from within the editor
    	remove_theme_support( 'widgets-block-editor' ); // Revert to the classic widget editing experience
}

add_action( 'after_setup_theme', 'jjm_2022_block_setup' );

/**
 * Some functionality is easier to remove with JS. Or only possible to remove with JS. 
 **/
add_action( 'init', 'jjm_remove_block_styles' );
function jjm_remove_block_styles() {
	// Register the block editor script.
	wp_register_script( 'remove-block-style', get_stylesheet_directory_uri() . '/assets/js/remove-block-styles.js', [ 'wp-blocks', 'wp-edit-post' ] );
	// I'm actually not at all sure what this does. 
	register_block_type( 'remove/block-style', [
		'editor_script' => 'remove-block-style',
	] );
}

/**
* Back to removing functionality via PHP
**/
function jjm_docs_block_editor_settings( $editor_settings, $editor_context ) {
    $editor_settings['__experimentalFeatures']['typography']['dropCap'] = false;

    return $editor_settings;
}
 
add_filter( 'block_editor_settings_all', 'jjm_docs_block_editor_settings', 10, 2 );


/************************************************
* Default Block Whitelist: only blocks in the whitelist are allowed
************************************************/
add_filter( 'allowed_block_types_all', 'jjm_allowed_block_types', 10, 2 );
 
function jjm_allowed_block_types( $allowed_block_types, $editor_context ) {

	$home_id = get_option('page_on_front');
	$current_post_id = $editor_context->post->ID;

	if ( $current_post_id == $home_id ) { // Restrict block(s) allowed on homepage. 
    
        return array(
            'acf/home-feature',
            'acf/home-post',
            'acf/products',
            'acf/magazine-highlights',
        );
    
    } else { // Restrict blocks in all other contexts
    	return array(
			'core/image',
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/gallery',
			'core/shortcode',
			'core/audio',
			'core/file',
			'core/video',
			'core/verse',
			'core/html',
			//'core/pullquote',
			'core/preformatted',
			//'core/search',
			'core/separator',
			'core/embed',
			'acf/largepullquote',
			'acf/blockquote',
			'acf/search-field',
			//'yoast/faq-block',
		);
    }
 
}

/**
 * Disable the block editor by template and/or page_id. Reverts to classic editor.
 * Courtesty of Bill Erickson:
 * https://www.billerickson.net/disabling-gutenberg-certain-templates/
 **/
function jjm_disable_editor( $id = false ) {

	$excluded_templates = array(
		//'projects.php',
	);

	$excluded_ids = array(
		//get_option( 'page_on_front' ),
		get_option( 'page_for_posts' )
	);

	if( empty( $id ) )
		return false;

	$id = intval( $id );
	$template = get_page_template_slug( $id );

	return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
}

/**
 * Disable Gutenberg by template
 *
 */
function jjm_disable_gutenberg( $can_edit, $post_type ) {

	if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
		return $can_edit;

	if( jjm_disable_editor( $_GET['post'] ) )
		$can_edit = false;

	return $can_edit;

}
add_filter( 'gutenberg_can_edit_post_type', 'jjm_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'jjm_disable_gutenberg', 10, 2 );