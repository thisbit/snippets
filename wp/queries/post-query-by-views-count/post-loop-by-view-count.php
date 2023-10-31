<?php

/*
* GenerateBlocks & GeneratePress implementation of post ordering based on post views.
*/

// set the view counter
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
 
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); 


// Add to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Views');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}

// modify the query block ouput order
function gb_query_by_views( $query_args, $attributes ) {
    if ( ! empty( $attributes['className'] ) && strpos( $attributes['className'], 'order_by_views' ) !== false ) {
        
        $query_args['post_type'] = 'post';
        
        $custom_args = array(
          'meta_key' => 'post_views_count',
          'orderby' => 'meta_value_num',
          'order' => 'DESC',
        );
    } else {
        return $query_args;
    }
    return array_merge( $query_args, $custom_args );
}
add_filter( 'generateblocks_query_loop_args', 'gb_query_by_views', 10, 2  );