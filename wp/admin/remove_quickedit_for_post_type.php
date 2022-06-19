<?php 
/** 
* Remove Quickedit from this CPT
* replace 'cpt_slug' with your cpt slug 
*/
function apuri_disable_quick_edit_in_podaci( $actions = array(), $post = null ) {
    if ( get_post_type() === 'cpt_clug' ) {
        if ( isset( $actions['inline hide-if-no-js'] ) ) {
            unset( $actions['inline hide-if-no-js'] );
        }
    }
    return $actions;
}
// add_filter( 'post_row_actions', 'apuri_disable_quick_edit_in_podaci', 10, 2 ); // if non hierarchical cpt (like post)
add_filter( 'page_row_actions', 'apuri_disable_quick_edit_in_podaci', 10, 2 ); // if hierarchical cpt (like page)