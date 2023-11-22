<?php
// Adds categories to wp media
if ( ! function_exists('thisbit_add_categories_to_attachments') ) {
	function thisbit_add_categories_to_attachments() {
			register_taxonomy_for_object_type( 'category', 'attachment' );
	} 
	add_action( 'init' , 'thisbit_add_categories_to_attachments' );
}
