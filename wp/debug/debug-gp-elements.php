<?php
/**
 * Print the elements arrays used on page.
 */

add_action( 'wp_head', 'apuri_get_your_elements' );
function apuri_get_your_elements() {
	global $generate_elements;
	?> 
	<pre style="min-height: 100vh; display: flex; flex-direction: column; align-items: flex-start; text-align: left;">
	<h2 style="margin-top: 90px" >Active GeneratePress Elements</h2> 
		<?php print_r($generate_elements); ?>
	</pre>
	<?php
}