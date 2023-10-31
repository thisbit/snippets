<?php 

/**
 * This snippet works blocks, add a email-button class to the button block and should be done 
 * this is a bit of an experiment so use with causion
 */



// Security
if ( ! defined( 'ABSPATH' ) ) : exit; endif;

function publication_email_link() {
	global $post;
    $title = get_the_title($post->ID);
    $link  = get_the_permalink($post->ID);
    $post_type = get_post_type($post->ID);

    // link parts (https://spencermortensen.com/articles/email-obfuscation/)
    $mailto   = '&#109;&#97;&#105;&#108;&#116;&#111;&#58;';
    $username = '&#105;&#110;&#102;&#111;';
    $domain   = '&#112;&#97;&#118;&#105;&#108;&#106;&#111;&#110;&#46;&#104;&#114;';
    $subject  = 'Kupnja knjige:' . $title;

    $contact = '<a href="' . $mailto . $username . '@' . $domain . '?subject=' . $title . '&body=' . $title . '<br>' . $link . '" class="obfuscated">'. $mailto . $username . '[at]' . $domain .'</a>';
    $order = '<a href="'. $mailto . $username . '@' . $domain . '?subject=' . $subject . '&body=' . $title . '<br>' . $link . '" class="obfuscated">'. $username . '[at]' . $domain .'</a>';

    // if publication post type, link produces slightly different email
    ($post_type != 'publikacija') ? $email_link = $contact : $email_link = $order; 
    
    ?>
    <script id="obf">
        window.addEventListener('DOMContentLoaded', () => {
            // get the toggle button
            const revealBook = document.querySelector('.email-button');
            if (!revealBook) return; // if not button, no party

            // build up the dom element to insert
            let linkWrapper = document.createElement('div');
            linkWrapper.classList.add('book-order');
            linkWrapper.innerHTML = <?php echo json_encode($email_link); ?>;

            // inserter
            function insertAfter(newNode, existingNode) {
                existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
            }

            // do the clicking
            revealBook.addEventListener('click', () => {
            maiLink = document.querySelector('.book-order');
            (typeof(maiLink) != 'undefined' && maiLink != null) ? maiLink.remove() : insertAfter(linkWrapper,  revealBook);
            });
        });
    </script>

    <?php
}
add_action('wp_head', 'publication_email_link');