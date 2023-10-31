<?php
  // Creates a link that takes user one step back (same as browser button), but does not require Js to work
  // Jeff Star code https://perishablepress.com/go-back-via-javascript-and-php/

  $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

  if (! is_front_page() || ! is_home() ) {
    if ( ! empty( $referer ) ) {

      echo '<a href="'. $referer .'" title="Return to the previous page">Go back</a>';

    } else {
      // in case $referer fails, more on jeff star link
      echo '<a href="javascript:history.go(-1)" title="Return to the previous page">Go back</a>';

    }
  }
?>