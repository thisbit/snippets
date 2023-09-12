<?php 

function detect_horizontal_scroll_elems() {
	?>
	<script id="detect-horiz-scroll">
	 window.addEventListener( 'DOMContentLoaded', ()=> {	document.querySelectorAll('*').forEach( (element) => { if (element.offsetWidth > document.documentElement.offsetWidth) { console.log(element); } } ); });
	</script>
	<?php
}

add_action('wp_footer', 'detect_horizontal_scroll_elems', 999 );