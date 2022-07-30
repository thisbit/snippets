<?php
/** 
 * Plugin Name: Post Object Based Loop in ShortCode 
 * @link https://gist.github.com/diggeddy/b71bf07aa55eecb0c34191f9fe05d224
 * Description: the ACF multiselect field, based on post object allows drag and drop functionality, so we can allow editors to choose and order posts
*/

// Shortcode function
function thisbit_advanced_loop_shortcode($atts, $content = null) {
	
	global $post;
	$people_objects = get_field( 'list-people' ); // get content of ACF post object
	
	if ( ! empty( $people_objects ) ) : // if it is not empty
	    ob_start();

    // some markup, stolen from core/query block layout
		echo wp_kses_post( '<div class="gb-inside-container">' );
		echo wp_kses_post( '<div class="is-flex-container columns-4 wp-block-post-template ">' );

		foreach ( $people_objects as $post ) : // each acf post object is a post
			setup_postdata( $post ); // breathe the data in
        
				do_action('thisbit_advanced_loop'); // call for a template built in generatepress element
		
			wp_reset_postdata( $post ); // breathe the data out
		
    endforeach; // end the loop
	  
    // the markup
		echo wp_kses_post( '</div>' );
		echo wp_kses_post( '</div>' );
		
		return ob_get_clean(); // clean the buffer
	endif;

}

add_shortcode('thisbit_show_advanced_loop', 'thisbit_advanced_loop_shortcode');


/**
 * Basic Styling 
 */
add_action( 'wp_head', function () { ?>
<style>
	@media (min-width: 600px) {
		.wp-block-post-template.is-flex-container.is-flex-container.columns-4>div, .wp-block-query-loop.is-flex-container.is-flex-container.columns-4>div {
			width: calc(25% - 0.9375em);
		}
	}
	
</style>
<?php } );