<?php
/*
 * conditional shortcode based on if the acf fild has any value used to render markup conditionally 
 * example usecase: [if arg="email"]<i class="mail-icon"></i> [acf field="email"][/if]
 */
function if_shortcode($atts, $content = null) {
    // Extract attributes and check if the specified argument exists
    $atts = shortcode_atts(array(
        'arg' => '',
    ), $atts);

    $arg_name = $atts['arg'];

    // Check if the ACF field has a value
    $acf_value = get_field($arg_name);

    if ($acf_value) {
        return do_shortcode($content);
    } else {
        return ''; // Return nothing if the ACF field is empty
    }
}
add_shortcode('if', 'if_shortcode');