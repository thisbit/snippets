<?php
/**
 * Adds quicktags to text mode in classic editor
 * @link https://wpsmackdown.com/add-custom-wordpress-quicktags/
 * @link https://code.tutsplus.com/tutorials/a-simple-guide-to-the-wordpress-quicktags-api--cms-22707
 * @link 
 */
function apuri_custom_quicktags() {
	if ( wp_script_is( 'quicktags' ) ) { ?>
		<script type="text/javascript">
			QTags.addButton( 'h2_tag', 'Heading L', '<h2>', '</h2>', '', '', 1 );
			QTags.addButton( 'h3_tag', 'Heading M', '<h3>', '</h3>', '', '', 2 );
			QTags.addButton( 'h4_tag', 'Heading S', '<h4>', '</h4>', '', '', 3 );
		</script>
	<?php }
}
add_action( 'admin_print_footer_scripts', 'apuri_custom_quicktags' );