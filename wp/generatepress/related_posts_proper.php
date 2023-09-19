<?php
/** 
* @use with GenerateBlocks / GeneratePress
* does not show the related post section if there is no related posts
**/
if ( ! function_exists( 'thisbit_related_posts' ) ) {
	function thisbit_related_posts() {

		if ( is_single() ) : // we use this on posts only
			$post_id     = get_the_ID();
			$cat_ids     = [];
			$categories  = get_the_category( $post_id );

			if( ! empty( $categories ) && ! is_wp_error( $categories ) ):
				foreach ($categories as $category):
					array_push( $cat_ids, $category->term_id );
				endforeach;
			endif;

			$args = [ 'category__in' => $cat_ids, 'post__not_in' => [$post_id] ];

			$related_posts = new WP_Query( $args );
			if ( $related_posts->have_posts() ) : do_action( 'thisbit_related_posts' ); endif; // here is the custom hook
		endif;
	}
}

add_action( 'generate_before_footer', 'thisbit_related_posts' );