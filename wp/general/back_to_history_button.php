<?php
/** 
 * A link that takes you back to page you came from
 * @link https://perishablepress.com/go-back-via-javascript-and-php/
 * Notice: I have updated the code from Jeff Star version, to prevent redirects if the link is coming from another website 
 */
		
// $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL); // Unsafe, keeping here for documentation.

// Checks weather referer validates, if not takes you to homepage
$referer = ( wp_get_referer() ) ? wp_validate_redirect( wp_get_referer() ) : get_home_url();
		
if ( ! empty( $referer ) ) {

	echo '<a href="'. $referer .'" title="Return to the previous page">Go back</a>';

} else {
	?>
	<script type="text/javascript">
		// Check weather link is taking you off site
		function backClick( event ) {
			if ( document.referrer.indexOf( window.location.host ) !== -1 ) {
				history.go(-1); return false;
			} else { 
				event.preventDefault();
			}
			}
	</script>
	<?php echo '<a onclick="backClick()" title="Return to the previous page" onMouseOver="this.style.cursor=\'pointer\'" >Go back</a>'; 

}
