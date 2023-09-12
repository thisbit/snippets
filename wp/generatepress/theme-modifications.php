<?php

/**
 * Adding custom global body class to call instead of body element
 * @link https://developer.wordpress.org/reference/functions/body_class/
 */

function apuri_custom_css_class( $classes ) {
	if ( ! is_admin() ) {
		$classes[] = 'apuri-body';
		return $classes;
	}
}
add_filter( 'body_class', 'apuri_custom_css_class' );

/**
 * Remove the default site-footer wrapper markup, after it was removed by dissable elements feature of GeneratePress
 * @link https://generatepress.com/forums/topic/conditional-test-for-disabled-elements/#post-424225
 * Would be nice to have a condition to check weather the site-footer was indeed dissabled
 */

function remove_site_footer_wrapper() {
	global $generate_elements;
	if ( $generate_elements[144] ) {
		?>
			<script type="text/javascript" id="apuri-default-footer-remove">
				const siteFooter = document.querySelector( ".site-footer" );	
				siteFooter.parentNode.removeChild( siteFooter );
			</script>
			<style>
				/** If no JS */
				.apuri-body > .site-footer {display: none; visibility: hidden;}
			</style>
		<?php
	}
}
// add_action('wp_footer', 'remove_site_footer_wrapper');

/**
 * Add placeholder to GP search field
 * @link https://docs.generatepress.com/article/generate_navigation_search_output/
 */

function apuri_search_placeholder() {
	printf(
			'<form method="get" class="search-form navigation-search" action="%1$s">
					<input type="search" placeholder="' .  __('Traži') . '" class="search-field" value="%2$s" name="s" title="%3$s" />
			</form>',
			esc_url( home_url( '/' ) ),
			esc_attr( get_search_query() ),
			esc_attr_x( 'Search', 'label', 'generatepress' ) 
	);
	
}
add_filter( 'generate_navigation_search_output', 'apuri_search_placeholder');



/**
 * Remove link from site title to prevent repeated links
 * @link https://docs.generatepress.com/article/generate_site_title_output/
 */
function apuri_remove_link_from_sitetitle( $output ) {
	return sprintf(
		'<%1$s class="main-title" itemprop="headline">
		%3$s
		</%1$s>',
		( is_front_page() && is_home() ) ? 'h1' : 'p',
		esc_url( apply_filters( 'generate_site_title_href', home_url( '/' ) ) ),
		get_bloginfo( 'name' )
	);
}
add_filter( 'generate_site_title_output', 'apuri_remove_link_from_sitetitle');


/** 
 * Embed SVG logo in GeneratePress header, in mobile and desktop
 * This works only if the logo is uploaded previously, because to replace html, theml element has to be there prior
 */
function apuri_svg_logo() {
	return sprintf( // WPCS: XSS ok, sanitization ok.
		'<div class="site-logo">
		<a href="%1$s" title="%2$s" rel="home">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 64 30" class="apuri-svg-logo" style="height:30px;width:64px"><path fill-rule="evenodd" clip-rule="evenodd" d="M11 14 6 0 0 14h11Z"/><path d="M26 26h-4v4h4v-4Z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M64 21a9 9 0 0 1-19 0V0h19v21ZM30 0a7 7 0 0 1 6 7 7 7 0 0 1-6 7h-4V0h4Z"/></svg> 
		</a>
		</div>',
		esc_url( apply_filters( 'generate_logo_href' , home_url( '/' ) ) ),
		esc_attr( apply_filters( 'generate_logo_title', get_bloginfo( 'name', 'display' ) ) )
	);
}
add_filter( 'generate_logo_output', 'apuri_svg_logo');
add_filter( 'generate_mobile_header_logo_output', 'apuri_svg_logo');



// customize search results header
add_shortcode('header_element_search',function(){
	ob_start();
	printf(
	/* translators: 1: Search query name */
	__( 'Search Results for: %s', 'generatepress' ),
	'<span class="search-query">' . get_search_query() . '</span>'
	);
	return ob_get_clean();
});

/**
 * Removes custom search title because we use element for that
 */
function apuri_remove_search_title() {
	remove_action( 'generate_before_loop', 'generate_do_search_results_title'  );
}
add_action( 'wp', 'apuri_remove_search_title' );


/**
 * Remove extraneous whitespace from excerpts on blog posts, post archives and search results
 * Double test the output
 */
add_filter( 'run_wptexturize', '__return_false' ); // removes wp feature that makes emdash from two consecutive dashes

function apuri_clean_post_content( $content ){

	$content = preg_replace( '/[\p{Z}\s]{2,}/mu', ' ', $content ); // trailing whitepace @link https://www.josheaton.org/wordpress-plugins/remove-double-space/
	$content = preg_replace('/[—-]{2,}/mu', '', $content); // repeating dashes
	$content = preg_replace( '#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content ); // empty p tags
	
	if ( is_archive() || is_search() ) {
		
		$allowed = array( 
			'p' => array(), 
			'a' => array() 
		);
		
		$content = wp_trim_words( $content, 30, ' [...]' ); // clip at words
		$content = substr( $content, 0, 500 ); // excerpt length safety net
		return wp_kses( $content, $allowed );
		
	} else if ( is_singular( 'post' ) ) {
		
		$content = str_replace( array( '<td>' ), '<p>', $content ); // wrap those td elements in p so that they are not without wrapper
		$content = strip_tags( $content, array( 'a', 'p', 'br', 'img', 'figure', 'figcaption', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li', 'div' ) );
		
		// remove p tags that wrap image tags in classic editor
		$content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);



		return $content;
	} else {
		return $content;
	}
}

add_filter( "the_content", "apuri_clean_post_content", 20, 1 );

	
/** 
 * Modify posts archive widget to show years only and exclude months
 */
function thisbit_limit_archives( $args ) {
	$args['type'] = 'yearly';
	return $args;
}

add_filter( 'widget_archives_args', 'thisbit_limit_archives' );
add_filter( 'widget_archives_dropdown_args', 'thisbit_limit_archives' );


//* Exclude Categories from Category Widget - basicWP.com
function custom_category_widget($args) {
	$exclude = 57; // Category IDs to be excluded
	$args["exclude"] = $exclude;
	return $args;
}
add_filter("widget_categories_args","custom_category_widget");
add_filter("widget_categories_dropdown_args","custom_category_widget");


/**
 * If posts are listed in pages and these are post types, truncate long titles
 * Works in conjunction with min-height css rule on post to force height to be the same
 */
function apuri_max_title_length( $title ) {
	if ( ! is_single() && ! is_archive() && ! is_search() && 'post' == get_post_type() ) {
		$max = 80;
		if ( strlen( $title ) >= $max ) {
			return wp_trim_words( $title, 8, '&hellip;' );
			} else {
				return $title;
			}
		} else {
			return $title;
		}
	}
add_filter( 'the_title', 'apuri_max_title_length');




add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'generate-child' ); /* Dont load useless style.css of the child theme */
    wp_dequeue_style('generate-fonts'); // make sure generatepress google fonts do not load
}, 50 );


/**
 * Remove Homepage from search results
 * 
 */
function apuri_exclude_front_page_from_search( $query ) {
	if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
		$pageID = array( get_option( 'page_on_front' ) );
		$query->set( 'post__not_in', $pageID);
	}
}
add_action( 'pre_get_posts', 'apuri_exclude_front_page_from_search' );


add_theme_support( 'disable-custom-colors' ); // User-defined colors
add_theme_support( 'disable-custom-gradients' ); // User-defined gradient
add_theme_support( 'editor-font-sizes', [] );
add_theme_support( 'disable-custom-font-sizes' );
remove_theme_support( 'block-templates' ); // Allows user to create their own templates from within the editor
remove_theme_support( 'core-block-patterns' ); // Allows user to create their own block patterns from within the editor
remove_theme_support( 'block-templates' ); // remove FSE templates from editor