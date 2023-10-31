<?php 
/*
 * @function Automatically call custom functions in Generateblocks Dynamic Data
 * @author Taylor Drayson
 * @since 22/09/2022
 *
 * Replace $key with your unique prefix for all custom functions
 * here is the original snippet https://gist.github.com/tdrayson/391573513bf54a6b2ab6ee2d57d7fadb
 * usecase https://share.getcloudapp.com/xQuxbn1o?fbclid=IwAR20y6OYDppFIUXwYckQa5o9L8kkl2081g8ss0Nij179bmu0qvHkxiPk9PQ
*/

add_filter( 'generateblocks_dynamic_content_output', function( $content, $attributes ) {
    if ( 'post-meta' === $attributes['dynamicContentType'] && isset( $attributes['metaFieldName'] ) ) {
        
        $key = 'tct'; // Replace with your unique key
        $match = preg_match('#^'.$key.'(.*)$#i', $attributes['metaFieldName']);
        
        if($match){
            return call_user_func($attributes['metaFieldName']);
        }
    }

    return $content;
}, 10, 2 );