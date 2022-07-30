<?php
/** 
* Shortcode to embed google drive public folders on the website.
* The translations and style are controled by google drive so use this only if you do not expect to have control over these.
* In my case this usefull for internal use on a hidden page for teams that need to send links to files as they are being worked on. 
*
* @param string [google_drive id="YourFolderID" style="[grid OR list]" width="" height=""]
* @todo use google drive cloud api to handle auth to show files in non public folders
* @link https://github.com/woodwardtw/gfolder_embed/blob/master/gfolder_embed.php (original code)
*/

function thisbit_google_drive_shortcode($atts, $content=null) {
    $atts = array_change_key_case( (array)$atts, CASE_LOWER );

    $a = shortcode_atts( array(
         'id'     => '',
         'style'  => 'list',
         'width'  => '100%',
         'height' => '500px',
    ), $atts);
  
	return '<iframe src="https://drive.google.com/embeddedfolderview?id=' . $a['id'] . '#' . $a['style'] . '" frameborder="0" width="' . $a['width'] . '" height="' . $a['height'].'" scrolling="auto"> </iframe>';
}

add_shortcode( 'google_drive', 'thisbit_google_drive_shortcode' );