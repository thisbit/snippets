<?php

/**
 * This filter attatches the wp grid builder facet to the generateblocks query block as an argument 
 * this is a bootstrap code for any gridbuilder facet
 **/

function gb_query_news( $query_args, $attributes ) {
    if ( ! empty( $attributes['className'] ) && strpos( $attributes['className'], 'arhiv-vijesti' ) !== false ) {
    	$query_args['wp_grid_builder'] = 'wpgb-content';
    }
    return $query_args;
}
add_filter( 'generateblocks_query_loop_args', 'gb_query_news', 10, 2  ); 