<?php

/**
 * This passes acf relationship field to the related posts loop as it displays on the single project page
 * Related function is shuk_related_posts which sets display conditions based on the value of this acf field 
 **/
function news_projects_relationship( $query_args, $attributes ) {
    if ( ! empty( $attributes['className'] ) && strpos( $attributes['className'], 'related-news' ) !== false ) {
      $query_args['post__in']        = get_field( 'related_projects_news' );
    	$query_args['orderby']         = 'post__in';
    	$query_args['posts_per_page']  = '-1';
    	$query_args['post_type']       = 'any';
    }
    return $query_args;
}
add_filter( 'generateblocks_query_loop_args', 'news_projects_relationship', 10, 2  );