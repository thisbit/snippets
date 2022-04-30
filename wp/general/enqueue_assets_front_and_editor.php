<?php
/**
 * This is a gist that goes with the following tutorial
 * @link https://thisbit.medium.com/animated-design-system-with-generatepresss-and-generateblocks-responsive-fluid-typography-292e02eeeb15
 */

function prefix_load_assets(  ) {
	wp_enqueue_style( 'prefix-type', get_stylesheet_directory_uri() .      '/assets/css/prefix-typography.css', false, '1.0.0', 'all');
}

add_action( 'wp_enqueue_scripts', 'prefix_load_assets', 9999 );
add_filter( 'admin_enqueue_scripts', 'prefix_load_assets');

function prefix_get_fonts() {
	?>
	<style id="local-web-fonts">
		@font-face {
		font-family: 'Work Sans';
		font-style: normal;
		font-weight: 400;
		src: local('Work Sans'),
			url('url/to/font/file/work-sans-v16-latin-ext_latin-regular.woff2') format('woff2');
			
}
/* work-sans-italic - latin-ext_latin */
@font-face {
		font-family: 'Work Sans';
		font-style: italic;
		font-weight: 400;
		src: local('Work Sans'),
			url('url/to/font/file/work-sans-v16-latin-ext_latin-italic.woff2') format('woff2');
}
	</style>
<?php
}
add_action( 'wp_head', 'prefix_get_fonts' );
add_action( 'admin_head', 'prefix_get_fonts' );