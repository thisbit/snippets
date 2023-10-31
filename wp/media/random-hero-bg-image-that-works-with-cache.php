<?php
/**
 * Random Home Hero Background image Feature
 * User can set Images in a Dedicated Options Page, so we keep Homepage away from different users.
 */

/**
 * Create the options page
 */
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Naslovna Random Hero Images',
		'menu_title'	=> 'Naslovna imgs',
		'menu_slug' 	=> 'home-hero-settings',
		'capability'	=> 'edit_posts',
		'icon_url'    => 'dashicons-images-alt2',
		'redirect'		=> false,
		"menu_position" => 31
	));
}

add_action( 'admin_head', function () { 
	if ( is_admin() ) {
	?>
		<style id="options-page">

			.wp-admin #acf-group_62b9a3f902a57 .inside.acf-fields {
				display: flex;
				flex-wrap: wrap;
				padding: 20px;
			}
			.wp-admin #acf-group_62b9a3f902a57 .inside.acf-fields .acf-field-image {
				width: 20%;
			}
			.wp-admin #acf-group_62b9a3f902a57  .inside.acf-fields .acf-field-message {
				width: 90%;
			}
		</style>
	<?php
	}	
} );


/**
 * Function that returns max 10 images as header background
 * Sends to JS as an array of images, then in JS picks one image on random
 * We are doing it this way to try avoid cacnhing background image as part of html
 */
function apuri_random_images_via_js( $url ) {
	if (class_exists('ACF')) {
		$images = array(
			esc_url(get_field('apuri_home_random_1', 'option' )),
			esc_url(get_field('apuri_home_random_2', 'option' )),
			esc_url(get_field('apuri_home_random_3', 'option' )),
			esc_url(get_field('apuri_home_random_4', 'option' )),
			esc_url(get_field('apuri_home_random_5', 'option' )),
			esc_url(get_field('apuri_home_random_6', 'option' )),
			esc_url(get_field('apuri_home_random_7', 'option' )),
			esc_url(get_field('apuri_home_random_8', 'option' )),
			esc_url(get_field('apuri_home_random_9', 'option' )),	
			esc_url(get_field('apuri_home_random_10', 'option'))
		);

		if ( is_front_page() ) {
			$images = array_values( array_filter( $images ) );
			?>
				<script type="text/javascript" id="random-images">
			    const defaultRandomHero = document.querySelector('.default-random-hero');
			    if ( typeof( defaultRandomHero ) != 'undefined' && defaultRandomHero != null ) {
			    	var imageArray = <?php echo json_encode($images); ?>;
						document.querySelector('.page-hero').style.background = 'url(' + imageArray[Math.floor(Math.random() * imageArray.length)] + ')' + ' center center / cover' + ' no-repeat';
					}
				</script>
				<style id="random-images"> .page-hero.default-random-hero { position: relative; } .page-hero.default-random-hero:after { content: ""; position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%; padding: 0; margin: 0; background-color: rgba(0,0,0,0.55) !important; z-index: 0; } .page-hero.default-random-hero > .inside-page-hero { position: relative; z-index: 1; }
				</style>
			<?php
		} else {
			return $url;
		}
	} else {
		return $url;
	}
}
add_filter( 'wp_footer', 'apuri_random_images_via_js');


function apuri_menu_order( $menu_ord ) {  
    
    if (!$menu_ord) return true;  
    
    // vars
    $menu = 'home-hero-settings';
    
    // remove from current menu
    $menu_ord = array_diff($menu_ord, array( $menu ));
    
    // append after index.php [0]
    array_splice( $menu_ord, 4, 0, array( $menu ) );
    
    // echo '<pre>';
    // print_r( $menu_ord );
    // echo '</pre>';
    // die;
    
    // return
    return $menu_ord;
}  

add_filter('custom_menu_order', 'apuri_menu_order');
add_filter('menu_order', 'apuri_menu_order');