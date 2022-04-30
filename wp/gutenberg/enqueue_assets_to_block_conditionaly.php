<?php
/** 
* Lookup weather block is present on any kind of page, if yes load the assets it needs
* @link https://mkaz.blog/wordpress/conditionally-load-block-assets/
*/

function thisbit_add_assets_to_blocktype() {
    global $posts;
    foreach ( $posts as $post ) {
        if ( has_block( 'scope/blockname', $post ) ) {
            the_assets();
            return;
        }
    }
} );
add_action( 'wp_enqueue_scripts', 'thisbit_add_assets_to_blocktype', 999);