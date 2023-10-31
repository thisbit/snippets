<?php

//remove default category (uncategorized) when another category has been set
function remove_default_category($ID, $post) {

    //get all categories for the post
    $categories = wp_get_object_terms($ID, 'category');

    //if there is more than one category set, check to see if one of them is the default
    if (count($categories) > 1) { 
        foreach ($categories as $key => $category) {
            //if category is the default, then remove it
            if ($category->name == "Uncategorized") {
                wp_remove_object_terms($ID, 'uncategorized', 'category');
            }
        }
    }
}
//hook in to the publsh_post action to run when a post is published
add_action('publish_post', 'remove_default_category', 10, 2);