<?php
/**
 * Adds a CSS variable ---the-scrollbar-width to prevent hirizontal scroll from appearing when blocks are fullwidth

#js
#gutenberg
#css

 */


// security
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The thing
function apuri_fullwidth_blocks_fix() {
	?>
	<script id="modify-fullwidth-blocks">
		function getTheScroolBarWidth() {
			document.documentElement.style.setProperty('--the-scrollbar-width', (window.innerWidth - document.documentElement.clientWidth) + "px");
		}
	
		window.addEventListener('resize', getTheScroolBarWidth, false); // watch for resizing

    document.addEventListener('DOMContentLoaded', getTheScroolBarWidth, false); // dom load

    window.addEventListener('load', getTheScroolBarWidth); // with assets
		</script>
		
    <style id="modify-fullwidth-blocks">
			.no-sidebar .entry-content .alignfull {
				max-width: calc( 100vw - var(--the-scrollbar-width) ) !important;
			}
		</style>
	<?php
};
add_action( 'wp_footer' , 'apuri_fullwidth_blocks_fix', 999);