<?php
/**
 * Restrict REST API access - Allow specific WP Grid Builder frontend endpoints only
 */

// Security for all files
require_once( WPMU_PLUGIN_DIR . '/security-header.php' );

function restrict_rest_api_access($result) {
    // Allow internal REST API requests
    if (defined('INTERNAL_REST_REQUEST') && INTERNAL_REST_REQUEST) {
        return $result;
    }

    // Get the actual REST route
    $route = '';
    if (isset($GLOBALS['wp']->query_vars['rest_route'])) {
        $route = $GLOBALS['wp']->query_vars['rest_route'];
    } elseif (isset($_GET['rest_route'])) {
        $route = $_GET['rest_route'];
    }

    // Only allow specific Grid Builder frontend endpoints
    $allowed_public_routes = array(
        // '/wpgb/v1/fetch',           // Frontend grid data fetching
        '/wpgb/v1/search',          // Frontend search functionality
        '/wpgb/v2/filter',          // Frontend filtering
        // '/wpgb/v2/grid',            // Frontend grid display
        '/wpgb_map/v2/popup',       // Map popup functionality (if using maps)
    );

    // Check if this is an allowed Grid Builder public route
    foreach ($allowed_public_routes as $allowed_route) {
        if (strpos($route, $allowed_route) === 0) {
            return $result;
        }
    }

    // Check if user is logged in and is admin
    if (!is_user_logged_in() || !current_user_can('administrator')) {
        return new WP_Error(
            'rest_forbidden',
            'Sorry, forbidden.',
            array('status' => 403)
        );
    }

    return $result;
}
add_filter('rest_authentication_errors', 'restrict_rest_api_access');

// Remove REST API info from headers  
remove_action('template_redirect', 'rest_output_link_header', 11);

// Remove REST API links from HTML head
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');



// Check what routes GridBuilder has REMOVE AFTER TESTING, test by visiting any rest endpoint

// Check for Grid Builder plugin and routes on every load
add_action('wp_loaded', function() {
    error_log('=== Checking for Grid Builder ===');
    
    // Check if Grid Builder is active
    if (class_exists('WP_Grid_Builder')) {
        error_log('Grid Builder plugin is active');
    } else {
        error_log('Grid Builder plugin NOT found');
    }
    
    // Check if REST API is available
    if (function_exists('rest_get_server')) {
        $server = rest_get_server();
        $routes = $server->get_routes();
        
        // Look for any Grid Builder related routes
        $wpgb_routes = array_filter(array_keys($routes), function($route) {
            return strpos($route, 'wpgridbuilder') !== false || 
                   strpos($route, 'wpgb') !== false ||
                   strpos($route, 'gridbuilder') !== false;
        });
        
        if (!empty($wpgb_routes)) {
            error_log('Found Grid Builder routes: ' . print_r($wpgb_routes, true));
        } else {
            error_log('No Grid Builder routes found');
        }
    } else {
        error_log('REST API not available');
    }
});

