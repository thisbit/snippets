<?php
/**
 * Remove the attatchment pages from site, add nofollow and redirect if someone reaches it anyway
 **/
function thisbit_remove_attachment_page() {
    if ( is_attachment() ) {
        // add noindex also 
        add_filter( 'wp_robots', 'wp_robots_no_robots' );
        // if there is a parent move there, if not goto home
        global $post;
        if ( is_a( $post, 'WP_Post' ) && ! empty( $post->post_parent ) ) {
            $redirect = esc_url( get_permalink( $post->post_parent ) );
        } else {
            $redirect = esc_url( home_url( '/' ) );
        }
        if ( wp_safe_redirect( $redirect, 301 ) ) {
            exit;
        }
    }
}
add_action( 'template_redirect', 'thisbit_remove_attachment_page' );