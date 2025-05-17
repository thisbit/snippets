<?php
/**
 * Plugin Name: APURI ACF Search Extension
 * Description: Extension for WordPress that enhances the default search functionality to include content stored in Advanced Custom Fields (ACF)
 * Version: 1.0.0.
 * Author: thisbit
 */
/**
 * Extend WordPress search to include ACF custom fields
 * 
 * Enhanced version with improved performance, security, and ACF targeting
 */

/**
 * ACF-enabled search extension
 */
class APURI_ACF_Search {
    // Store excluded meta keys statically
    private static $excluded_meta_keys = [
        '_edit_lock', '_edit_last', '_wp_page_template', '_wp_attached_file', 
        '_wp_attachment_metadata', '_menu_item_type', '_menu_item_menu_item_parent',
        '_menu_item_object', '_menu_item_object_id', '_menu_item_target',
        '_thumbnail_id', '_wp_trash_meta', '_wp_old_slug', '_revision',
        '_edit%', '_%_key', '_%_hash'
    ];
    
    // Store sensitive ACF fields that should be excluded
    private static $sensitive_acf_fields = [
        // Add sensitive fields here, e.g., 'user_password', 'api_key'
    ];
    
    /**
     * Initialize hooks
     */
    public static function init() {
        // Allow customization of excluded meta keys
        self::$excluded_meta_keys = apply_filters('apuri_search_excluded_meta_keys', self::$excluded_meta_keys);
        
        // Allow customization of sensitive ACF fields
        self::$sensitive_acf_fields = apply_filters('apuri_search_sensitive_acf_fields', self::$sensitive_acf_fields);
        
        // Setup hooks for search queries
        add_action('pre_get_posts', [self::class, 'setup_search_hooks']);
        
        // Check for cached results
        add_action('pre_get_posts', [self::class, 'check_cached_results']);
    }
    
    /**
     * Check if we have cached results for this search query
     *
     * @param WP_Query $query The WordPress query object
     */
    public static function check_cached_results($query) {
        if (is_search() && !is_admin() && $query->is_main_query()) {
            $search_term = sanitize_text_field(get_search_query());
            $cache_key = 'apuri_search_' . md5($search_term . serialize($query->query_vars));
            
            $cached_post_ids = get_transient($cache_key);
            
            if (false !== $cached_post_ids && is_array($cached_post_ids)) {
                // We have cached results, use them
                $query->set('post__in', $cached_post_ids);
                $query->set('orderby', 'post__in');
                
                // Skip the regular search processing since we're using cached results
                add_filter('posts_search', function($search) {
                    return '';  // Empty search clause
                }, 999);
            }
        }
    }
    
    /**
     * Set up necessary hooks for search queries
     *
     * @param WP_Query $query The WordPress query object
     */
    public static function setup_search_hooks($query) {
        if (is_search() && !is_admin() && $query->is_main_query()) {
            // Only if we don't have cached results
            $search_term = sanitize_text_field(get_search_query());
            $cache_key = 'apuri_search_' . md5($search_term . serialize($query->query_vars));
            
            if (false === get_transient($cache_key)) {
                // Add filters for this specific query
                add_filter('posts_join', [self::class, 'search_join']);
                add_filter('posts_where', [self::class, 'search_where']);
                add_filter('posts_groupby', [self::class, 'posts_groupby']);
                
                // Cache post IDs after the query is complete
                add_filter('the_posts', [self::class, 'cache_search_results'], 10, 2);
                
                // Clean up filters after the query
                add_filter('the_posts', function($posts) {
                    remove_filter('posts_join', [self::class, 'search_join']);
                    remove_filter('posts_where', [self::class, 'search_where']);
                    remove_filter('posts_groupby', [self::class, 'posts_groupby']);
                    return $posts;
                }, 999);
            }
        }
    }
    
    /**
     * Join posts and postmeta tables
     *
     * @param string $join The JOIN clause of the query
     * @return string The modified JOIN clause
     */
    public static function search_join($join) {
        global $wpdb;
        $join .= " LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id ";
        return $join;
    }
    
    /**
     * Modify the search query to include ACF fields
     *
     * @param string $where The WHERE clause of the query
     * @return string The modified WHERE clause
     */
    public static function search_where($where) {
        global $wpdb;
        
        // Bail early if no where clause
        if (empty($where)) {
            return $where;
        }
        
        // Get and sanitize search term
        $search_term = sanitize_text_field(get_search_query());
        if (empty($search_term)) {
            return $where;
        }
        
        try {
            // Prepare excluded meta keys
            $exclude_conditions = [];
            
            // System meta keys
            foreach (self::$excluded_meta_keys as $excluded_key) {
                $exclude_conditions[] = $wpdb->prepare("{$wpdb->postmeta}.meta_key NOT LIKE %s", $excluded_key);
            }
            
            // Sensitive ACF fields
            foreach (self::$sensitive_acf_fields as $sensitive_field) {
                $exclude_conditions[] = $wpdb->prepare("{$wpdb->postmeta}.meta_key != %s", $sensitive_field);
            }
            
            // Add condition to target ACF fields (typically don't start with underscore)
            $exclude_conditions[] = "{$wpdb->postmeta}.meta_key NOT LIKE '\_%'";
            
            // Combine conditions
            $exclude_sql = implode(' AND ', $exclude_conditions);
            
            // Get meta rows limit (default 50)
            $meta_limit = apply_filters('apuri_search_meta_limit', 50);
            
            // Create a safer regex pattern for the replacement
            $pattern = "/\(\s*" . preg_quote($wpdb->posts, '/') . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/";
            
            // Build replacement with meta field search
            $replacement = "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . 
                $exclude_sql . " AND " .
                $wpdb->postmeta . ".meta_value LIKE $1)";
            
            // Apply the modification with error checking
            $new_where = @preg_replace($pattern, $replacement, $where);
            
            if (null === $new_where) {
                // Log the error and use the original WHERE clause
                error_log('ACF Search Extension: Regex error in search_where - ' . preg_last_error());
                return $where;
            }
            
            return $new_where;
        } catch (Exception $e) {
            // Log the error
            error_log('ACF Search Extension: Error in search_where - ' . $e->getMessage());
            return $where;
        }
    }
    
    /**
     * Prevent duplicates with GROUP BY
     *
     * @param string $groupby The GROUP BY clause of the query
     * @return string The modified GROUP BY clause
     */
    public static function posts_groupby($groupby) {
        global $wpdb;
        return "{$wpdb->posts}.ID";
    }
    
    /**
     * Cache search results to improve performance
     *
     * @param array $posts Array of post objects
     * @param WP_Query $query The WordPress query object
     * @return array The original array of post objects
     */
    public static function cache_search_results($posts, $query) {
        if (is_search() && !is_admin() && $query->is_main_query()) {
            // Only cache if we have results
            if (!empty($posts)) {
                $search_term = sanitize_text_field(get_search_query());
                $cache_key = 'apuri_search_' . md5($search_term . serialize($query->query_vars));
                
                // Extract post IDs for caching
                $post_ids = wp_list_pluck($posts, 'ID');
                
                // Cache for 1 hour
                set_transient($cache_key, $post_ids, DAY_IN_SECONDS);
            }
        }
        
        return $posts;
    }
    
    /**
     * Clear the search cache when posts are updated
     *
     * @param int $post_ID Post ID
     */
    public static function clear_search_cache($post_ID) {
        // Delete all transients with our prefix
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM $wpdb->options WHERE option_name LIKE %s",
                '_transient_apuri_search_%'
            )
        );
    }
    
    /**
     * Clear LiteSpeed cache when relevant content changes
     *
     * @param int $post_ID Post ID
     */
    public static function clear_litespeed_cache($post_ID) {
        // Only proceed if LiteSpeed Cache is active
        if (class_exists('LiteSpeed\Core') && method_exists('LiteSpeed\Purge', 'purge_all')) {
            // Clear all LiteSpeed cache
            do_action('litespeed_purge_all');
        }
    }
}

// Allow developers to disable the feature
if (!defined('APURI_DISABLE_ACF_SEARCH') || !APURI_DISABLE_ACF_SEARCH) {
    // Initialize the class
    add_action('init', ['APURI_ACF_Search', 'init']);
    
    // Clear cache when content changes
    add_action('save_post', ['APURI_ACF_Search', 'clear_search_cache']);
    add_action('deleted_post', ['APURI_ACF_Search', 'clear_search_cache']);
    add_action('updated_post_meta', ['APURI_ACF_Search', 'clear_search_cache']);
    add_action('added_post_meta', ['APURI_ACF_Search', 'clear_search_cache']);
    add_action('deleted_post_meta', ['APURI_ACF_Search', 'clear_search_cache']);
    
    // Clear LiteSpeed cache when content changes
    add_action('save_post', ['APURI_ACF_Search', 'clear_litespeed_cache']);
    add_action('deleted_post', ['APURI_ACF_Search', 'clear_litespeed_cache']);
}