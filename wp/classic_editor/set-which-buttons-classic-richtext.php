<?php
/**
 * Set which buttons are available to classic editor
 * @warning, if you use this you cannot use gutenberg anywhere on the site, as well as acf ... not verbatim at least
 */
function apuri_tinymce_editor_buttons() {
	if ( get_post_type() === 'cpt-slug' ) {
		return array(
			// "undo", 
			// "redo", 
			// "separator",
			// "bold", 
			"italic",
			"link",
			"unlink",
			// "underline", 
			// "strikethrough", 
			//"separator",
			//"bullist", 
			//"separator",
			//add more here...
		);
	}
}

function apuri_tinymce_editor_buttons_second_row(  ) {
	//return an empty array to remove this line
	if ( get_post_type() === 'cpt-slug' ) {
		return array();
	}
}
add_filter("mce_buttons", "apuri_tinymce_editor_buttons", 99); //targets the first line
add_filter("mce_buttons_2", "apuri_tinymce_editor_buttons_second_row", 99); //targets the second line


