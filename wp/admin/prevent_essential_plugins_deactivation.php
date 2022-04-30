<?php
/** 
 * Lets say your site depends on plugins such as acf and you do not want user to mistakenly dissable it.
 * You have two options, move the plugin to mu-plugins folder and enable autoloading for mu-plugins, or add the acf folder to mu-plugins
 * Otherwise, in case your plugin for whatever reason should not go to mu-plugins, just dissable the disable link!
 */

function thisbit_disable_plugin_deactivation( $actions, $plugin_file, $plugin_data, $context ) {
 
    if ( array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file, array(
        'advanced-custom-fields/acf.php',
        'gp-premium/gp-premium.php'
    )))
        unset( $actions['deactivate'] );
    return $actions;
}

add_filter( 'plugin_action_links', 'thisbit_disable_plugin_deactivation', 10, 4 );
