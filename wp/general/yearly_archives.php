<?php
/** 
 * Modify posts archive widget to show years only and exclude months
 */
function thisbit_limit_archives( $args ) {
    $args['type'] = 'yearly';
    return $args;
}

add_filter( 'widget_archives_args', 'thisbit_limit_archives' );
add_filter( 'widget_archives_dropdown_args', 'thisbit_limit_archives' );