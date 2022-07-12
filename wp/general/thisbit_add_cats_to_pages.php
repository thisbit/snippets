<?php
/** 
* Adds categories and tags to your pages.
* add this to your functions.php, snippets plugin, or mu-plugin
*/

function thisbit_add_taxonomies_to_pages() {
 register_taxonomy_for_object_type( 'post_tag', 'page' );
 register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'thisbit_add_taxonomies_to_pages' );
