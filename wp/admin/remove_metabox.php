<?php
/**
* Remove metabox from editor
* @link https://developer.wordpress.org/reference/functions/remove_meta_box/
* Reason: i prefer to control the taxonomies via ACF taxonomy field, as it allows me to set the field as mandatory so we do not end up with 
* the poststype not placed in proper taxonomy. If you are doing this, then it is a good idea to remove the taxonomy metabox so that you do not confuse
* the client/editor by doubling the settings elements
*/

function apuri_remove_meta_box(){
	// Taxonomy remove
	remove_meta_box( 'taxonomynamediv', 'cptname', 'side' );
}
add_action( 'add_meta_boxes', 'apuri_remove_meta_box' );

/**
If it is your taxonomy, which you have registered, then this is more elegant
*/
$args = array(
  'labels'                     => $labels,
  'hierarchical'               => true,
  'public'                     => true,
  'show_ui'                    => true,
  'show_admin_column'          => true,
  'show_in_nav_menus'          => false,
  'show_tagcloud'              => false,
  'query_var'                  => 'slug',
  'show_in_rest'               => false,
  'meta_box_cb'                => false, // this removes custom taxonomy from editor
  'rest_base'                  => 'slug',
  'rewrite'                    => 'slug',
);
register_taxonomy( 'tax_name', array( 'cpt_name' ), $args );