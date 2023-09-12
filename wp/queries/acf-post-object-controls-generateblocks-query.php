<?php
/**
 * This snippet modifies the output of the GenerateBlocks Query Loop Block by controling the arguments
 * via the ACF (Free and Pro) Post Object Field
 * You need to create the post object field, and se it to pass ID not object
 * Then this will pass the array of post IDs as arguments for the query
 **/


function gb_query_news( $query_args, $attributes ) {
    if ( ! empty( $attributes['className'] ) && strpos( $attributes['className'], 'order_by_acf' ) !== false ) {
        $post_obs = get_field('front_posts');
        
    	$query_args['post__in']   = $post_obs;
    	$query_args['orderby']    = 'post__in';
    	$query_args['post_type']  = 'any';
    }
    return $query_args;
}
add_filter( 'generateblocks_query_loop_args', 'gb_query_news', 10, 2  );



/**
 * DEBUG function bellow
 */

function apuri_get_your_elements() {
	$post_obs = get_field('front_posts');

	?> 
	<pre style="min-height: 100vh; display: flex; flex-direction: column; align-items: flex-start; text-align: left;">
	<h2 style="margin-top: 90px" >Check the array content</h2> 
	
		<?php 
// 		foreach ($post_obs as $postob) {
// 		    echo $postob->ID;
// 		}
		// print_r(array_keys($post_obs));
	print_r($post_obs);
		
		?>
	</pre>
	<?php
}
// add_action( 'wp_head', 'apuri_get_your_elements' );