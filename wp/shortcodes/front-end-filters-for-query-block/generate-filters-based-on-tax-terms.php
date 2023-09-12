<?php
/**
 * Shortcode for generating filters to filter output of GenerateBlocks query loop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Shortcode function
 */
function apuri_generate_filters( $atts ) {
	
	ob_start();

	// Setting up taxonomy name to be defined in the shortcode
	$apuri_tax = [];
	$atts = shortcode_atts( array(
		'cat' => $apuri_tax,
	), $atts );
	$apuri_tax = $atts[ 'cat' ];
	
	// preparing taxonomy as a variable to send to js
	$data_to_js = [];
	$data_to_js['apuri_taxonomy'] = $apuri_tax;
	
	// sending to js
	wp_localize_script( 'apuri-filtering-assets', 'php_vars', $data_to_js );

	// getting the terms of the taxonomy defined above
	$apuri_tax_tems = get_terms( $apuri_tax, 'orderby=name&hide_empty=1'  );

	// start filter navigation markup
?>

	<nav class="widget inner-padding widget_block widget_search staff-menu apuri-filter-menu" aria-label="<?php _e( 'Sekundarni izbornik' ); ?>" role="navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope>
		<ul class="secondary-menu">
			<li class="js-search-list-item">
				<form class="search-form vanilla" role="search" aria-label="<?php _e( 'Lokalna pretraga stranice' ); ?>" >
					<div>
						<input class='input' tabindex="2"  type="search" id="searchbox" placeholder="<?php _e( 'Traži' ); ?>">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="8.26087" cy="8.26087" r="7.76087" stroke="#222222"/>
							<path d="M14 14L19 19" stroke="#222222"/>
						</svg>
					</div> 
					<input type="hidden" tabindex="2" class="search-reset" value="<?php _e( 'Poništi' ); ?>">
				</form>
			</li>
				<span class="filter-label"><?php _e( 'Filter' ); ?></span>
				<li>
					<a role="link" tabindex="2" class="reset-filters active" id="reset" ><?php _e( 'Sve' ); ?></a>
				</li>
			<?php
				foreach ( $apuri_tax_tems as $apuri_term ) {
						$kslug = $apuri_term->slug;
						$kname = $apuri_term->name;
						if ( ! empty( $kslug ) ) { ?>
							<li>
								<a 
								href="#page"
								tabindex="2"
								class="filter" 
								role="link"				
								id="<?php echo $kslug; ?>"
								/> <?php echo $kname; ?></a>
							</li>
							<?php
						}
					}
			?>
		</ul>
	</nav>

	<?php
	// clean before finish
	return ob_get_clean();
}

add_shortcode( 'apuri_loop_filter', 'apuri_generate_filters' );

/** 
 * Enqueue the assets for the filtering only when shortcode is present on page
 * In case you are using this within your theme replace plugin_dir_url( __FILE__ ) bellow with get_stylesheet_directory() and add a slash before assets/...  
*/
function apuri_staff_filtering_assets() {
  global $post;
  if ( has_shortcode( $post->post_content, 'apuri_loop_filter' ) ) : 
    wp_enqueue_style( 'apuri-filtering-assets', plugin_dir_url( __FILE__ ) . 'assets/apuri-filtering-assets.css', false, '1.0.0.', 'all' );
    wp_enqueue_script( 'apuri-filtering-assets', plugin_dir_url( __FILE__ ) . 'assets/apuri-filtering-assets.js', false, '1.0.0.', 'all' );
  endif;
}
add_action( 'wp_enqueue_scripts', 'apuri_staff_filtering_assets' );