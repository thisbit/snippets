<?php
/**
 * Plugin Name: Thisbit Documents List Plugin
 * Plugin URI: https://gists.github.com/thisbit/apuri-custom-content
 * Description: This plugin creates a shortcode to display a list of links to download documents. It is based on WP_Query for Attatchment post type. Then it takes the document of the attatchment and creates link to it. The text of the link can be based on filename, and attatchment post type name. Files are segmented using categories. Here you can use default wp category (no other plugins needed, so celeaner, but not as user friendly to manage files this way) or some plugin that makes it easier to handle files, in which  case use the plugins custom taxonomy. PLugins I tried are "Media Library organizer" and "Happyfiles". In addition to this, shortcode enables to chose filetypes to shot, the order etc.
 * Version: 1.0.0
 * Requires at least: 5
 * Tested up to: 5.9.2
 * Requires PHP: 7.3
 * Author: Thisbit
 * License: GPLv2 or later
 */

/**
* Output links to attatchments and filter with categories
* @param string $file "application/pdf" defaults to pdf
* @param string $cat write cat slug to filter attatchments to show
* Example shortcode [apuri_docs cat=category-name file=xls]
*/
 
// Wp native category, works with no plugin

if ( ! function_exists('apuri_add_categories_to_attachments') ) {
	function apuri_add_categories_to_attachments() {
		if ( ! class_exists( 'Media_Library_Organizer' ) && ! class_exists( 'HappyFiles\\Init' ) ) {
			register_taxonomy_for_object_type( 'category', 'attachment' );
		} 
	} 
	add_action( 'init' , 'apuri_add_categories_to_attachments' );
}

/**
 * Shortcode filetype options
	[pdf] => 'application/pdf'
	[doc] => 'application/msword'
	[docx] => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
	[xls] => 'application/vnd.ms-excel'
	[xlsx] => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
 */

if ( ! function_exists('apuri_document_lists') ) {
	function apuri_document_lists( $atts ) {

	// prepare vars
	$cat       = [];
	$file      = [];
	$order     = [];
	$orderby   = [];
	$max_files = [];
	$mimetypes = [];
	
	// shortcode atts, defaults to override with shortcode atts
	$atts = shortcode_atts( array(
		'file'      => $file,    // default is pdf, for others one has to specify
		'cat'       => $cat,     // category has to be set, otherwise all files will be listed
		'orderby'   => 'title',
		'order'     => 'ASC',
		'max_files' => 20,
	), $atts );
	

	// get the values from shortcode atts
	$cat       = $atts[ 'cat' ];
	$file      = $atts[ 'file' ];
	$order     = $atts[ 'order' ];
	$orderby   = $atts[ 'orderby' ];
	$max_files = $atts[ 'max_files' ];


	// shortcode atts string to array filetypes
	$filetypes = explode( ',' , $atts['file'] );


	// for safety check if these are allowed and use values from get_allowed_mime_types() 
	foreach ( $filetypes as $type ) {
		if ( isset( get_allowed_mime_types()[ $type ] ) ) {
			$mimetypes[ $type ] = get_allowed_mime_types()[ $type ];
		}
	}
	// if not allowed
	if ( sizeof( $mimetypes ) == 0) {
		return '';
	}

	ob_start();

	/**
	* Works with plugins
	* Media Library Organizer @link https://wordpress.org/plugins/media-library-organizer/ - free plugin
	* Or HappyFiles @link https://happyfiles.io/ - free and premium
	*/

	// Use avalilable taxonomy, prefer plugin tax, but none is there use native category registered above from 25 - 31ln
	
	$apuri_media_categories = 'category'; // WP native, use without plugin

	if ( class_exists( 'Media_Library_Organizer' ) && ! class_exists('HappyFiles\\Init') ) {
		$apuri_media_categories = 'mlo-category'; // Use with Media Library Organizer
	} elseif ( class_exists('HappyFiles\\Init') && ! class_exists( 'Media_Library_Organizer' ) ) {
		$apuri_media_categories = 'happyfiles_category'; // Use with HappyFiles
	}

	// query arguments controled with shortcode atts
	$args = array (
	'post_type'	     => 'attachment',
	'post_status'    => 'any',
	'posts_per_page' => $max_files,
	'tax_query' => array(
		array(        
			'taxonomy' => $apuri_media_categories,
			'field'    => 'slug',
			'terms'    => array( $cat ),
			'operator' => 'IN',
		),
	),
	'order'		       => $order,
	'orderby'	       => $orderby,
	'post_mime_type' => $mimetypes,
	);


	$query_docs= new WP_Query( $args );

	if ( $query_docs->have_posts() ) {
	?>
	<ul class="document-list">
	<?php
		while ( $query_docs->have_posts() ) {
		
			$query_docs->the_post(); ?>
					<?php
						$the_post = '';
						$fileurl  = wp_get_attachment_url( $the_post );
						$filename = wp_basename( $fileurl );
						$filename = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $filename );
				
						$filetype = wp_check_filetype( $fileurl )['ext']; // get the extenstion

						echo '<li><a href="' . esc_url( $fileurl ) . '" class="document' . ' ' . esc_attr( $filetype ) . '">';
						
						echo esc_html( $filename ); // if we want to pull it from filename
						
						// echo esc_html( the_title() . '.' . $filetype['ext'] ); // if we want to base the link text of the atatchment title
						
						echo '</a></li>'; 
					?>
				<?php
		}
	?>
	</ul>					
	<?php
	}
	wp_reset_postdata();
	$output = ob_get_clean();
	return $output;
	}
}
add_shortcode( 'apuri_docs', 'apuri_document_lists' );