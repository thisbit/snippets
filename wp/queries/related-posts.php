<?php
/**
 * Apuri Related Posts section
 */
if ( ! function_exists( 'apuri_related_posts' ) ) {
	function apuri_related_posts() {

		if ( is_single() && 'post' === get_post_type() ) : // we use this on posts only
			$post_id           = get_the_ID();
			$current_post_type = get_post_type( $post_id );
			$cat_ids           = array();
			$categories        = get_the_category( $post_id );

			if( ! empty( $categories ) && ! is_wp_error( $categories ) ):
				foreach ($categories as $category):
					array_push( $cat_ids, $category->term_id );
				endforeach;
			endif;

			$args = array( 
					'category__in'   => $cat_ids,
					'post_type'      => $current_post_type,
					'post__not_in'   => array($post_id),
					'posts_per_page' => '4',
					'order'          => 'DESC',
					'orderby'        => 'date'   
			);

			$related_posts = new WP_Query( $args );

			if ( $related_posts->have_posts() ) : ?>
			<section class="gb-container related-posts">
				<h2 class="gb-headline gb-headline-text"><?php _e( 'Vezane vijesti' ); ?></h3>
				<div class="gb-grid-wrapper gb-grid-wrapper-wide-layout">
				<?php while( $related_posts->have_posts() ) : ?>
					<?php $related_posts->the_post(); ?>
					<div class="gb-grid-column gb-grid-column-wide-half-column">
						<?php do_action( 'apuri_related_posts' ); ?>
					</div>
					<?php endwhile; ?>
				</div>
			</section>
				<?php wp_reset_postdata();
     endif;
		endif;
	}
}

add_action( 'generate_after_content', 'apuri_related_posts' );