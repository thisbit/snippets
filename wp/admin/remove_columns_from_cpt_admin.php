<?php 
/** 
* Remove date column
*/
function apuri_hide_date_columns( $columns ) {
    unset($columns['date']);
    return $columns;
}
add_filter( 'manage_edit-cpt_clug_columns', 'apuri_hide_date_columns' );