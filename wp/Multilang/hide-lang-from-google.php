<?php
	/**
	 * These shippets hide specified language from indexing
	 * @dependencies slim seo & polylang 
	 */

// italian
add_filter( 'slim_seo_robots_index', function( $value ) {
    if( pll_current_language() == 'it'  ){
        return false;
    }
    return $value;
} );

// german
add_filter( 'slim_seo_robots_index', function( $value ) {
    if( pll_current_language() == 'de'  ){
        return false;
    }
    return $value;
} );

// hungarian
add_filter( 'slim_seo_robots_index', function( $value ) {
    if( pll_current_language() == 'hu'  ){
        return false;
    }
    return $value;
} );