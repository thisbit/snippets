<?php 
/**
 * This snippet renders a reading time for the current post
 * @source https://goldpenguin.org/blog/calculate-wordpress-reading-time-without-a-plugin/ 
 * @use add shortcode [reading_time] where you wish to display this
 **/

// Add Shortcode
function gp_reading_time() {
    global $post;
  $article = get_post_field( 'post_content', $post->ID ); //gets full text from article
    $wordcount = str_word_count( strip_tags( $article ) ); //removes html tags
    $time = ceil($wordcount / 250); //takes rounded of words divided by 250 words per minute
  
    if ($time == 1) { //grammar conversion
      $label = "min";
    } else {
      $label = "min";
    }
  
    $totalString = $time . $label; //adds time with minute/minutes label
    return "<span class='" . esc_attr('read-time') . "' ><span class='label'>" . esc_html("read time ") . "</span>" . esc_html($totalString) . "</span>";

}
add_shortcode( 'reading_time', 'gp_reading_time' );