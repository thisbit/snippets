<?php
/** 
 * Create meta descriptions on any site page. 
 */


function apuri_head_meta() {
 global $post;

	if ( is_category() ) { // In Categories use Category Descriptions
		$content = category_description( get_the_category()[0]->cat_ID );
	}
	
	// Use Blog Description? Not a good Idea. Maybe CPT, or even hardcoded, because this often goes to title tag too.
	if ( is_home() || is_front_page() ) {
		$content = bloginfo( 'description' ); 
	}

	// For Single Pages. Return the excerpt() if it exists other truncate.
	if ( is_singular() ) {
		if ( ! empty( $post->post_excerpt ) ) {
		$content = $post->post_excerpt;
		} elseif ( ! empty( $post->post_content ) ) {
			$content = wp_trim_words( $post->post_content, 40, '...' );
		} else {
			return;
		}
	}

 ?>
  <meta name="description" content="<?php echo esc_attr( strip_tags( stripslashes( $content ) ) ); ?>" />
 <?php
}

add_action( 'wp_head', 'apuri_head_meta', 10 );