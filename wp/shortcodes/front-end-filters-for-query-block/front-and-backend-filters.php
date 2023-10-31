<?php
/**
 * This is an earlier version of this solution, it does not use generateblocks query as at that time it did not exist, it used frontend js based filters, but has backend filters as fallback
 * @link here is how https://www.youtube.com/watch?v=oLewJ3r-LDw
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function apuri_staff_filters_and_loops( $do ) {

		// Get katedra terms
		$katedra_terms = get_terms(
			array(
				'taxonomy'   => 'apuri_katedra',
				'hide_empty' => true,
			)
		);

		// fallback filters
		if ( isset($_GET['katedra']) && ! empty( $_GET['katedra'] ) ) {
			$katedra = esc_html__( $_GET['katedra'] );
		} else {
			$katedra = array( 'grafika', 'slikarstvo', 'intermedija', 'kiparstvo', 'teorija', 'crtanje', 'gluma' );
		} if ( isset($_GET['order']) && ! empty( $_GET['order'] ) ) {
			$order = esc_html__(  $_GET['order'] );
		} else {
			$order = esc_html__( 'ASC' );
		}

		?>
		
		
	<div class="inside-right-sidebar">

			<!-- FALLBACK FILTERS FORM -->
			<form class="no-js" action="<?php the_permalink(); ?>" method="get" id="nastavnici-fallback-filter" onchange="document.getElementById('nastavnici-fallback-filter').submit();">	
				<fieldset id="filters-2">

					<label><?php _e( 'Filtriraj' ); ?></label>
					<a href="<?php the_permalink(); ?>"><?php _e('sve') ?></a>

				<?php
					foreach ( $katedra_terms as $katedra_term ) :
						// escaping
						$kslug = esc_html__( $katedra_term->slug );
						$kname = esc_html__( $katedra_term->name );

						if ( ! empty( $kslug ) ) : ?>

							<label for="<?php echo $kslug; ?>"><input type="radio" name="katedra" id="<?php echo $kslug; ?>" value="<?php echo $kslug; ?>" <?php 
			
							echo  ( $kslug == $katedra ) ? 'checked' : ''; 
							
							?> /> <?php echo $kname; ?></label>
							<?php
						endif;
					endforeach;
				?>
					<select name="order" id="order" >
						<option value="ASC" 
						<?php echo ( 'ASC' == $order ) ? 'selected="selected"' : ''; ?>
						onchange="document.getElementById('nastavnici-fallback-filter').submit()" >ASC</option>
						<option value="DESC" 
						<?php echo ( 'DESC' == $order ) ? 'selected="selected"' : ''; ?>
						onchange="document.getElementById('nastavnici-fallback-filter').submit()" >DESC</option>
					</select>
					<input type="hidden" value="filter" >
				</fieldset>
			</form>

			<!-- END OF FALLBACK FILTERS FORM -->

			<!-- JS SEARCH AND FILTERS BLOCK -->
			<nav class="needs-js hide-me" aria-label="Secondary" role="navigation" itemtype="https://schema.org/SiteNavigationElement">
				<form class="needs-js hide-me">
					<input class='input mb-5' type="search" id="searchbox" placeholder="<?php _e( 'Traži' ); ?>">
					<input type="reset" class="search-reset" value="<?php _e( 'Poništi' ); ?>">
				</form>
				<a role="link" class="reset" aria-pressed="false" tabindex="1" id="reset"><?php _e( 'Sve' ); ?></a>
			<?php
				$tabindex = '2';
				foreach ( $katedra_terms as $katedra_term ) {
						$kslug = $katedra_term->slug;
						$kname = $katedra_term->name;
						if ( ! empty( $kslug ) ) { ?>
							<a 
							class="filter" 
							role="link" 
							aria-pressed="false" 
							tabindex="<?php echo $tabindex++; ?>"
							id="<?php echo $kslug; ?>"
							/> <?php echo $kname; ?></a>
							<?php
						}
					}
			?>
			</nav>
	<!-- JS SEARCH AND FILTERS BLOCK -->	
	</div>
	<!-- JS QUERY AND LOOPS BLOCK -->
	<div class="staff-page-content">
		
		<?php

		$args = array( // single args of the single query
			'post_type' => array ( 'apuri_osoblje' ),
			'order'		 => $order,
			'orderby'  => 'title',
			'tax_query' => array(
				array(        
					'taxonomy' => 'apuri_katedra',
					'field'    => 'slug',
					'terms'    => $katedra,
					'operator' => 'IN',
				),
			),
		);

	global $post;
	$zaposlenici = 'da';


	$query = new WP_query ( $args ); // single query
		?>
			<h2><?php _e('Zaposlenici'); ?></h2>
			<section class="zaposlanici staff grid">
			<?php
		
		if ( $query->have_posts() ) : // master if
				// loop one
				while ( $query->have_posts() ) : $query->the_post();
				if ( get_post_type() === 'apuri_osoblje' && has_term( $zaposlenici, 'apuri_zaposlenici' ) ) {
					?> 
							<article <?php post_class(); ?> >
								<div class="post-thumbnail">
									<?php the_post_thumbnail( 'medium' ) ?>
								</div>
								<header>
									<h3><a href="<?php the_permalink(); ?>" ><?php the_title(); // Prepare post templates with GP block hook ?></a></h3>
								</header>
							</article>
						<?php
						}
				endwhile;
				rewind_posts(); // this is crucial
				?>
			</section>
			
			
			<h2><?php _e('Suradnici'); ?></h2>
			<section class="suradnici staff grid">
			<?php
					// loop two
					while ( $query->have_posts() ) : $query->the_post();
						if ( get_post_type() === 'apuri_osoblje' && ! has_term( $zaposlenici, 'apuri_zaposlenici' ) ) {
							?>
							<article <?php post_class(); ?> >
								<div class="post-thumbnail">
									<?php the_post_thumbnail( 'medium' ) ?>
								</div>
								<header>
									<h3><a href="<?php the_permalink(); ?>" ><?php the_title(); // Prepare post templates with GP block hook ?></a></h3>
								</header>
							</article>
						<?php
						}
					endwhile;
					rewind_posts(); // this is crucial
				?>
			</section>
		</div>
		<script type="text/javascript" id="staff-filtering-functionality-js">

			// provide alternatives for nojs browsers
			window.addEventListener( "DOMContentLoaded", (event) => {

				const noJS    = Array.from(document.querySelectorAll(".no-js"));
				const needsJS = Array.from(document.querySelectorAll(".needs-js"));

				noJS.forEach( element    => element.classList.add( "hide-me" ) );
				needsJS.forEach( element => element.classList.remove( "hide-me" ) );
			
			}, false );

			// get the DOM elements
			let cards         = document.querySelectorAll('.hentry');
			let filterButtons = document.querySelectorAll( ".filter" );
			let resetFileters = document.querySelector( "#reset" );
			
			// live search function
			function liveSearch() {
					let search_query = document.getElementById("searchbox").value;
					
					//Use innerText if all contents are visible
					//Use textContent for including hidden elements
					for (let i = 0; i < cards.length; i++) {
							if(cards[i].textContent.toLowerCase()
											.includes(search_query.toLowerCase())) {
									cards[i].classList.remove("is-hidden");
							} else {
									cards[i].classList.add("is-hidden");
							}
					}
			}
			
			// filer functionality
			function filterCards( katedra ) {
				for (let i = 0; i < cards.length; i++) {
					if ( cards[i].classList.contains( katedra ) ) { // if you belong to my collection
								cards[i].classList.remove( "is-hidden" ); // do not be
						} else if ( ! cards[i].classList.contains( katedra ) ) { // if you are not in my collection
									cards[i].classList.add( "is-hidden" ); // please hide
							}	
						// if one clicks on reset, reveal all cards
						resetFileters.addEventListener('click', () => { 
								cards[i].classList.remove( "is-hidden" );
						}, false );

						resetFileters.addEventListener('keyup', ( event ) => { 
							if ( event.key === "Enter" ) {
									cards[i].classList.remove( "is-hidden" );
							}
						}, false );
					}
				}
				
				
				// Delay stuff, useful for the search function
				let typingTimer;               
				let typeInterval = 500;  
				let searchInput = document.getElementById('searchbox');
				let searchReset = document.querySelector('.search-reset');

				// run search as one types
				searchInput.addEventListener('keyup', () => {
					clearTimeout(typingTimer);
					typingTimer = setTimeout(liveSearch, typeInterval);
				});

				// reset search with button
				searchReset.addEventListener('click', () => {
					typingTimer = setTimeout(liveSearch, typeInterval);
				});

				// do the same for keyboard
				searchReset.addEventListener('keyup', () => {
					typingTimer = setTimeout(liveSearch, typeInterval);
				});
				
				// make those filters do stuff both with mouse and keyboard
				for (let i = 0; i < filterButtons.length; i++) {

					filterButtons[i].addEventListener('click', () => { filterCards( "apuri_katedra-" + filterButtons[i].id ); }, false );
					filterButtons[i].addEventListener('keyup', (event) => { 
						if ( event.key === "Enter" ) {
							filterCards( "apuri_katedra-" + filterButtons[i].id ); 
						}
					}, false );
				}

			
		</script>
		<style id="staff-filtering-functionality-css">

			.hide-me {
				display: none;
			}


			.is-hidden {
				display: none;
			}

			.grid {
				display: flex;
				flex-wrap: wrap;
			}

			.hentry {
				flex: 1;
			}

			.post-thumbnail {
				width: 300px;
				height: 300px;
			}

			.post-thumbnail img {
				width: 100%;
				height: 100%;
				object-fit: cover;
			}

			.filter, .reset {
				cursor: pointer;
				padding-right: 1em;
				user-select: none;
			}
		</style>
	
	<?php endif; // end master if
	return $do;
}

add_filter( 'generate_do_template_part',  'apuri_staff_filters_and_loops' );
// this generate_do_template_part( 'apuri_staff_template' ); goes to page template where you want to display grit with filtering 
