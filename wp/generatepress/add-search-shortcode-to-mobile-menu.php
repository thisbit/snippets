<?php
/* make shortcode search */
add_shortcode('wpbsearch', 'get_search_form');

/* 
* insert it into mobile menu 
* @link https://generatepress.com/forums/topic/hook-inside-idmobile-menu/#post-2272347
*/
function prefix_add_div( $items, $args ) {
  if ( $args->theme_location != 'primary' || ! wp_is_mobile() ) {
        return $items;
    } 
    $items .= '<li class="menu-item custom-menu-item form-list-item">'.do_shortcode( '[wpbsearch]' ).'</li>';
    return $items;
}
add_filter( 'wp_nav_menu_items', 'prefix_add_div', 15, 2 );