<?php
/** 
 * Push CSS to head to hide toggled blocks if GeneratePress is neither te active theme nor a parent theme
 * 
*/
function apuri_conditional_blocks_css() {
    $theme = wp_get_theme();
    
    if ( $theme->template !== 'generatepress' &&
         $theme->name     !== 'generatepress' ) {
        ?>
        <style id="thisgut-hide-toggled-blocks">
          /* Add inline CSS. */
        </style>;
      <?php
    }
}
add_filter( 'wp_head', 'apuri_conditional_blocks_css' );