<?php
/**
 * Template name: Single Query Multiple Loops
 * Description: This is a concept gist, the idea is that it would be more performant to have less DB queries and then sort data in PHP.
 * @package WordPress
 * @subpackage GeneratePress
 * @link https://code.tutsplus.com/tutorials/how-to-code-multiple-loops-while-only-querying-the-database-once--cms-25703
 * @link https://wpmudev.com/blog/how-to-use-one-query-to-run-multiple-loops/
 * @todo Add transients in the query to serve from there instead of DB where applicable
 * Author: @thisbit
*/

get_header();

$args = array(
	'post_type' => array ( 'people', 'post' ),
);
 
$query = new WP_query ( $args );

if ( $query->have_posts() ) {

	$my_post_type = get_post_type() == 'people';

	if ( $my_post_type == 0 ) :
		echo '<h2>people</h2>';
	endif;
	?>
	<section class="people-posts grid">
	<?php 
		$count = 0;
		while ( $query->have_posts() ) : $query->the_post();
		// start second loop for posts
		if ( get_post_type() === 'people' && $count < 4 ) {
			$count +=1;
			?>
					<article class="entry">
						<?php do_action( 'thisbit_homepage_people_loop' ); // Prepare post templates with GP block hook ?>
					</article>
				<?php
				}
				
		endwhile; // end first loop for people cpts
		rewind_posts();
		?>
	</section>
	<?php
    $my_post_type = get_post_type( $post->ID ) == 'post';
			if ( $my_post_type == 1 ) :
				echo '<h2>posts</h2>';
			endif;
  ?>
	<section class="blog-posts grid">
	<?php
			
			$count = 0;
			while ( $query->have_posts() ) : $query->the_post();
			// start second loop for posts
				if ( get_post_type() === 'post' && $count < 4 ) {
					$count +=1;
					?>
					<article class="entry">
						<?php do_action( 'thisbit_homepage_posts_loop' ); // Prepare post templates with GP block hook ?>
					</article>
				<?php
				}

			endwhile; // end second loop for posts
			rewind_posts();
		?>
	</section>

	</body>

</html>
<?php }

get_footer();