<?php

// Set the options page (Depends on ACF Pro)
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Home Page Hero Settings',
		'menu_title'	=> 'Home Hero',
		'menu_slug' 	=> 'home-hero-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

// Style for options page
add_action( 'admin_head', function () { 
	if ( is_admin() ) {
	?>
		<style id="options-page">
			.wp-admin.toplevel_page_home-hero-settings .inside.acf-fields {
				display: flex;
				flex-wrap: wrap;
				padding: 20px !important;
			}
			.wp-admin.toplevel_page_home-hero-settings .inside.acf-fields .acf-field {
				width: 20%;
			}
			
		</style>
	<?php
	}	
} );

// Set the fields for options page (remove the "options" argument if you are using free ACF)
add_filter( 'generate_page_hero_background_image_url', function( $url ) {
    $headers = array(
        esc_url(get_field('r_img_1', 'option')),
        esc_url(get_field('r_img_2', 'option')),
        esc_url(get_field('r_img_3', 'option')),
        esc_url(get_field('r_img_4', 'option')),
        esc_url(get_field('r_img_5', 'option')),
        esc_url(get_field('r_img_6', 'option')),
        esc_url(get_field('r_img_7', 'option')),
        esc_url(get_field('r_img_8', 'option')),
    	esc_url(get_field('r_img_9', 'option')),	
        esc_url(get_field('r_img_10', 'option'))
    );
    // remove empty values from array
    $headers = array_values( array_filter( $headers ) );
    $url = $headers[ rand( 0, count( $headers ) -1 ) ] . '?cache_buster=' . rand( 0, 999999999); 
    return $url;
} );

// Style the header
add_action( 'wp_head', function () { ?>
<style>
	
.thisbit-random-image-hero {
    display: grid;
    grid-template-columns: 1fr repeat(5, minmax( auto, 296px)) 1fr;
    grid-template-rows: repeat(5, 1fr);
    grid-column-gap: 40px;
    grid-row-gap: 0px;
	
	background-position: 250px top;
}

.thisbit-random-image-hero .inside-page-hero { 
	/* these are for its role as grid child */
	grid-area: 1 / 1 / 6 / 5;
		
	/* these are for its role as grid parent */
	display: grid;
	grid-template-columns: 1fr repeat(3, minmax( auto, 296px));
	grid-template-rows: repeat(5, 1fr);
	grid-column-gap: 40px;
	grid-row-gap: 0px;
	}
	
.thisbit-random-image-hero .branding-container__background {grid-area: 1 / 1 / 6 / 4;  background-color: #000;}
.thisbit-random-image-hero .branding-container__info { grid-area: 3 / 2 / 5 / 5; margin-left: -20px;}

	
</style>
<?php } );