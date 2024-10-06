<?php

/**
* Delte posts older then a year
* This has not been tested, I am putting it here for myself to play with in the future
*/

function delete_old_posts() {
    $args = array(
        'post_type' => 'post',
        'date_query' => array(
            array(
                'column' => 'post_date',
                'before' => date('Y-m-d H:i:s', strtotime('-12 months')),
            ),
        ),
        'posts_per_page' => -1,
    );

    $old_posts = get_posts($args);
    foreach ($old_posts as $post) {
        wp_delete_post($post->ID, true); // true for permanent deletion
    }
}

// Hook into WordPress Load 
add_action('wp_loaded', 'delete_old_posts');
