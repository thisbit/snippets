<?php

/**
 * Event query with GenerateBlocks 
 * Show only events that are happening in future, and order them from sooner to later
 * @link https://community.generateblocks.com/t/generateblocks-query-loop-args-slowing-pages-way-down/903/9
 * @link https://community.generateblocks.com/t/use-gb-query-loop-for-related-post/688/2
 */

function gb_query_events( $query_args, $attributes ) {
    if ( ! empty( $attributes['className'] ) && strpos( $attributes['className'], 'upcoming-events' ) !== false ) {
    	$query_args['post_type'] = 'my_events';
        $query_args['orderby'] = 'meta_value_num'; // better for numbers
        // $query_args['orderby'] = 'meta_value'; // better for strings
       	$query_args['order'] = 'ASC';

	$custom_args = array(
		'meta_query' => array(
			'relation' => 'AND',
			// Get all posts that have the "expire_date" meta value
			array(
				'meta_key' => 'my_evente_date',
				'compare' => 'EXISTS',
			),
			// And get all posts that have lower expiration date than today
			array(
				'key'     => 'my_evente_date',
				'value'   => date("Y-m-d"),
				'type'    => 'DATE',
				'compare' => '>',
			),
		),
    );
      return array_merge( $query_args, $custom_args ); 
    } else {
    	return $query_args; // leave other query blocks alone
    }  
}

add_filter( 'generateblocks_query_loop_args', 'gb_query_events', 10, 2  );