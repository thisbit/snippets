<?php 
/**
* This file supports the management of the custom post type "Publikacija" in the administration area
* - it creates aditional columns (publish year, in stock, and price)
* - it creates dropdown filters for years and stock state
* - it removes date dropdown as it is not relevant for this post type
*/

if ( ! defined( 'ABSPATH' ) ) : exit; endif;


/**
* Add "stanje_na_lageru" column to the "publikacija" post type admin screen
*/
function add_stanje_na_lageru_column($columns) {
    $columns['stanje_na_lageru'] = __('Na zalihi');
    return $columns;
}
add_filter('manage_publikacija_posts_columns', 'add_stanje_na_lageru_column');

/**
* Display the value of "stanje_na_lageru" custom field in the "publikacija" post type admin screen
*/
function display_stanje_na_lageru_column($column, $post_id) {
    if ($column === 'stanje_na_lageru') {
        $stanje_na_lageru = get_post_meta($post_id, 'stanje_na_lageru', true);
        $color = ($stanje_na_lageru) ? '#04D939' : '#cacaca';
        $label = ($stanje_na_lageru) ? 'DA' : 'NE';
        echo '<div class="circle" style="background-color: ' . $color . '; height: 12px; width: 12px; border-radius: 6px;"></div> ' . $label;
    }
}
add_action('manage_publikacija_posts_custom_column', 'display_stanje_na_lageru_column', 10, 2);

/**
* Make "stanje_na_lageru" column sortable for the "publikacija" post type
*/
function make_stanje_na_lageru_column_sortable($columns) {
    $columns['stanje_na_lageru'] = 'stanje_na_lageru';
    return $columns;
}
add_filter('manage_edit-publikacija_sortable_columns', 'make_stanje_na_lageru_column_sortable');

/**
* Modify the query when sorting by "stanje_na_lageru" column for the "publikacija" post type
*/
function sort_stanje_na_lageru_column($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $screen = get_current_screen();
    if ($screen->post_type === 'publikacija') {
        $orderby = $query->get('orderby');
        if ($orderby === 'stanje_na_lageru') {
            $query->set('meta_key', 'stanje_na_lageru');
            $query->set('orderby', 'meta_value');
            $query->set('meta_type', 'NUMERIC');
        }
    }
}
add_action('pre_get_posts', 'sort_stanje_na_lageru_column');


/**
* Add a custom dropdown filter above the list of custom posts
*/
function add_custom_post_filter() {
    global $typenow, $wp_query;

    // Check if the current screen is the custom post type screen where you want to apply the filter
    if ($typenow == 'publikacija') {
        // Get the terms from the "publish_year" taxonomy
        $terms = get_terms('publish_year');

        if ($terms) {
            // Output the dropdown filter HTML
            echo '<select name="publish_year_filter">';
            echo '<option value="">' . __("All Years") . '</option>';

            foreach ($terms as $term) {
                echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
            }

            echo '</select>';
        }
    }
}
add_action('restrict_manage_posts', 'add_custom_post_filter');

/**
* Apply the taxonomy filter to the custom post list query
*/
function apply_custom_post_filter($query) {
    global $pagenow, $typenow;

    // Check if we are on the admin post list screen and the current screen is the custom post type screen
    if ($pagenow == 'edit.php' && $typenow == 'publikacija') {
        $filter_value = isset($_GET['publish_year_filter']) ? $_GET['publish_year_filter'] : '';

        if (!empty($filter_value)) {
            $query->query_vars['tax_query'] = array(
                array(
                    'taxonomy' => 'publish_year',
                    'field' => 'slug',
                    'terms' => $filter_value,
                ),
            );
        }
    }
}
add_filter('parse_query', 'apply_custom_post_filter');



/** 
* Add a custom dropdown filter for ACF boolean field above the list of custom posts
*/
function add_acf_boolean_dropdown_filter() {
    global $typenow, $wp_query;

    // Check if the current screen is the custom post type screen where you want to apply the filter
    if ($typenow == 'publikacija') {
        $current_stanje_na_lageru = isset($_GET['stanje_na_lageru_filter']) ? $_GET['stanje_na_lageru_filter'] : '';

        // Output the dropdown filter HTML
        echo '<select name="stanje_na_lageru_filter">';
        echo '<option value="">' . __("All Stock") . '</option>';
        echo '<option value="1"' . selected('1', $current_stanje_na_lageru, false) . '>' . __("On Stock") . '</option>';
        echo '<option value="0"' . selected('0', $current_stanje_na_lageru, false) . '>' . __("Empty") . '</option>';
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'add_acf_boolean_dropdown_filter');


/**
* Modify the query to filter based on the selected ACF boolean value
*/
function modify_custom_post_list_query($query) {
    global $typenow, $pagenow;

    // Check if the current screen is the custom post type screen and the main query
    if ($typenow == 'publikacija' && $pagenow == 'edit.php' && isset($_GET['stanje_na_lageru_filter'])) {
        $stanje_na_lageru_value = $_GET['stanje_na_lageru_filter'];

        // Modify the meta query to filter based on the ACF boolean field
        $query->query_vars['meta_query'][] = array(
            'key'     => 'stanje_na_lageru',
            'value'   => $stanje_na_lageru_value,
            'compare' => 'LIKE'
        );
    }
}
add_action('pre_get_posts', 'modify_custom_post_list_query');



/**
* Set the custom column for publikacije where we show the price of the publication
*/
function add_custom_column_to_admin_screen($columns) {
    $columns['cijena_publikacije'] = 'Cijena';
    return $columns;
}
add_filter('manage_publikacija_posts_columns', 'add_custom_column_to_admin_screen');

function display_custom_field_value_in_admin_screen($column, $post_id) {
    if ($column === 'cijena_publikacije') {
        $cijena_publikacije = get_field('cijena_publikacije', $post_id);

        echo ($cijena_publikacije) ? $cijena_publikacije . '&euro;' : '';
    }
}
add_action('manage_publikacija_posts_custom_column', 'display_custom_field_value_in_admin_screen', 10, 2);



/**
* remove the default date dropdown from the admin page 
*/
function remove_default_publish_date_filter_css() {
    global $typenow;

    // Check if the current screen is the custom post type screen where you want to remove the filter
    if ($typenow == 'publikacija' && is_admin()) {
        echo '<style>#filter-by-date { display: none !important; }</style>';
    }
}
add_action('admin_head-edit.php', 'remove_default_publish_date_filter_css');


