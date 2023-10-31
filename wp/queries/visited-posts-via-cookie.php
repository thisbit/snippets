<?php

/**
 * Visited Posts Section
 * this snippet stores the visited posts IDs in the COOKIE
 * then it uses that array as query argument
 **/


// stores visited posts into a cookie

function rv_products_non_logged_in(){ 
    $rv_posts = array();
    if ( is_singular('post')  && !is_user_logged_in()  ){
        if(isset($_COOKIE['rv_products']) && $_COOKIE['rv_products']!=''){ 
            $rv_posts =  unserialize($_COOKIE['rv_products']);
            if (! is_array($rv_posts)) {
                $rv_posts = array(get_the_ID());
            }else{
                $rv_posts = array_diff($rv_posts, array(get_the_ID()));
                array_unshift($rv_posts,get_the_ID());
            }   
        }else{
            $rv_posts = array(get_the_ID());
        }
        setcookie( 'rv_products', serialize($rv_posts) ,time() + ( DAY_IN_SECONDS * 31 ),'/');
    }
}
add_action('template_redirect', 'rv_products_non_logged_in');


// displays the loop
function display_visited_loop() {

    if(isset($_COOKIE['rv_products']) && $_COOKIE['rv_products']!=''){
        if ( is_front_page() ) : 
            $post_ids = unserialize($_COOKIE['rv_products']);
            global $post;
            ?>
            <style>
                .loop {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 3rem;
                }
            
        
                
                .visited img {
                    max-width: 100%;
                }
            </style>
            <h2> visited posts </h2>
            <div class="loop">
                
            <?php
            foreach ( $post_ids as $id) {
                $post = get_post($id);
                setup_postdata($post);
                ?>
                <article class="visited">
                <h3><a href="<?php echo get_the_permalink($id); ?>"><?php echo get_the_title($id); ?></a></h3>
                <?php echo get_the_post_thumbnail($id); ?>
                </article>
                <?php
                wp_reset_postdata();
            }
            ?>
            </div>
            <h2> general posts </h2>
        <?php
        endif;
    }
}
add_action('generate_before_main_content', 'display_visited_loop');