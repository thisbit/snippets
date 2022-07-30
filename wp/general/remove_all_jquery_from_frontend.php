<?php
/** 
* Completely Remove jQuery From WordPress FrontEnd
* Warning, this will remove jquery no matter what, so if you use a plugin, or theme uses it ... that will brake
*/

function thisbit_remove_jquery() {
    if ( ! is_admin() ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', false );
    }
}
add_action('init', 'thisbit_remove_jquery');