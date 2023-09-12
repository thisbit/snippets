<?php

/*
* This snippet replaces the generateblocks headline block with the class of event-duration ad inserts a event duration data
* we have start date and end date and we provide formating options
* there is also correctly formated datetime attribute
* using this we can easily add language based conditions and provide different formats per language
*/
add_filter( 'render_block_generateblocks/headline', function( $block_content, $block ) {
    $target_class = 'event-duration';
    // check if the headline block has a CSS class of $target_class
    if ( 
        ! empty( $block['attrs']['className'] ) && 
        strpos( $block['attrs']['className'], $target_class ) !== false 
    ) {
        $post_id = get_the_ID();

        // Get the start and end date values directly from post metadata, using get_post_meta as formating did not work with get_field()
        // print out format
        $start = get_post_meta( $post_id, 'start_date', true );
        $end   = get_post_meta( $post_id, 'end_date', true );
        
        // format for the datetime attribute
        $datetime_start = date('Y-m-d H:i:s', strtotime($start));
        $datetime_end   = date('Y-m-d H:i:s', strtotime($end));

        // if start date is empty, bail because then it's not an event
        if ( empty( $start ) ) {
            return;
        } else {
            if ( empty( $end ) ) { // no end date, single-date event has a full date
                $formatted_date_start       = date('d. m. Y.', strtotime($start));
                return "<div class='gb-headline-post-date some'><time datetime='$datetime_start'>$formatted_date_start</time></div>";
            } else {
                // when we have both dates, first does not print the year
                $formatted_date_short_start = date('d. m.', strtotime($start));
                $formatted_date_end         = date('d. m. Y.', strtotime($end));
                $short_start                = date('d. m.', strtotime($start));
                return "<div class='gb-headline-post-date some'><time datetime='$datetime_start'>$formatted_date_short_start</time> &ndash; <time datetime='$datetime_end'>$formatted_date_end</time></div>";
            }
        }
    }
    return $block_content;
}, 10, 2 );
