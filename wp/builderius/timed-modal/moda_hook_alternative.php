<?php
// if no cookie bail early
if (!empty($_COOKIE['overlayHider'])) return;

// now we can define the custom hook here, and hook it to generatepress after header hook so it appears there
function my_custom_hook() {
    do_action( 'my_custom_hook' );
}
add_action('generate_after_footer', 'my_custom_hook');

// and in another function we could make some thing that loads images and all using generatepress elements for instance
// and none of that would render at all if the cookie is valid still
function my_gallery_with_images() {
  echo "bunch of stuff with images";
}
add_action('my_custom_hook', 'my_gallery_with_images');