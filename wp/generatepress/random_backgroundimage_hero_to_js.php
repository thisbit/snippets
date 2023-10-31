<?php
/**
 * Function that returns max 10 images as header background
 * Sends to JS as an array of images, then in JS picks one image on random
 * We are doing it this way to try avoid cacnhing background image as part of html
 */
function apuri_random_images_via_js( $url ) {
	$images = array(
		esc_url(get_field('apuri_home_random_1', 'option' )),
		esc_url(get_field('apuri_home_random_2', 'option' )),
		esc_url(get_field('apuri_home_random_3', 'option' )),
		esc_url(get_field('apuri_home_random_4', 'option' )),
		esc_url(get_field('apuri_home_random_5', 'option' )),
		esc_url(get_field('apuri_home_random_6', 'option' )),
		esc_url(get_field('apuri_home_random_7', 'option' )),
		esc_url(get_field('apuri_home_random_8', 'option' )),
		esc_url(get_field('apuri_home_random_9', 'option' )),	
		esc_url(get_field('apuri_home_random_10', 'option'))
	);
	if (  is_front_page()  ) {
		$images = array_values( array_filter( $images ) );
		?>
			<script type="text/javascript" id="random-images">
		    var imageArray = <?php echo json_encode($images); ?>;
				document.querySelector('.page-hero').style.background = 'url(' + imageArray[Math.floor(Math.random() * imageArray.length)] + ')' + ' center center / cover' + ' no-repeat';
			 </script>
			<style id="random-images"> .page-hero { position: relative; } .page-hero:after { content: ""; position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%; padding: 0; margin: 0; background-color: rgba(0,0,0,0.55) !important; z-index: 0; } .page-hero > .inside-page-hero { position: relative; z-index: 1; } </style>
		<?php
	} else {
		return $url;
	}
}
add_filter( 'wp_footer', 'apuri_random_images_via_js');