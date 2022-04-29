<?php
/**
 * Query Shortcode to display courses table
 * Example shortcode [apuri_courses cat=category-name prof=prof-name]
 * @depends on ACF plugin and CPT here reffered to as apuri_kolegij
 */

// require_once( ACC_PATH . '/inc/no-direct.php' );   // security



// the meat
if ( ! function_exists('apuri_course_table') ) {
	function apuri_course_table( $atts ) {

	// prepare vars
	$cat       = [];
	$prof      = [];
	$max       = [];
	$order     = [];
	$orderby   = []; // options are title, menu_order, date
	
	// shortcode atts, defaults to override with shortcode atts
	$atts = shortcode_atts( array(
		'prof'      => $prof,    // specify nositelj name
		'cat'       => $cat,     // specify category term name
		'orderby'   => 'title',
		'order'     => 'ASC',
		'max'       => 20,
	), $atts );
	

	// get the values from shortcode atts
	$cat       = $atts[ 'cat' ];
	$prof      = $atts[ 'prof' ];
	$order     = $atts[ 'order' ];
	$orderby   = $atts[ 'orderby' ];
	$max       = $atts[ 'max' ];


	// shortcode atts string to array course_cats
	

	ob_start();

	
	$args = array (
	'post_type'	     => 'apuri_kolegij',
	'post_status'    => 'publish',
	'posts_per_page' => $max,
	'tax_query' => array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'apuri_nositelji',
			'terms'    => array( $prof ),
			'field'    => 'slug',
			'operator' => 'IN',
		),
		array(
			'taxonomy' => 'apuri_kolegiji',
			'terms'    => array( $cat ),
			'field'    => 'slug',
			'operator' => 'IN',
		),
	),
	'order'		       => $order,
	'orderby'	       => $orderby,
	);


	$query_courses= new WP_Query( $args );
	global $post;
	if ( $query_courses->have_posts() ) :	?>

		<script id="course-table-description-toggle">

			/**
			 * Toggle functionality
			*/
			window.addEventListener("DOMContentLoaded", (event) => {
				const buttons = Array.from(document.querySelectorAll(".has-description"));

				function toggle(triggers) {
					const handleClick = (event) => {
						event.preventDefault();
						event.currentTarget.classList.toggle("toggled");
						event.currentTarget.lastElementChild.classList.toggle("open");
					};

					const clicker = buttons.forEach((element) => {
						element.addEventListener("click", handleClick, false);
					});

					return clicker;
				}
				toggle(buttons);
			});

		</script>

		<style>

		.header-row, .course-content {
				display: flex;
				flex-wrap: wrap;
		}

		
		th, td {
			flex-grow: 1;
			flex-shrink: 1;
			word-wrap: normal;
			text-align: left;
		}
		tr.has-description:hover {
			cursor: pointer;
			background-color: #eee;
		}
		
		td.course-title {position: relative;}
		
		tr.has-description .course-title {
			padding-left: 2.35em;
		}

		tr.has-description .course-title:before {
			content: '';
			position: absolute;
			display: inline-block;
			left: .5em;
			top: 50%;
			margin-top: -8.5px;
			background-image: url("data:image/svg+xml,%3Csvg fill='none' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 17 17'%3E%3Cpath stroke='%23FF5E5E' d='M8.5 0v17M0 8.5h17'/%3E%3C/svg%3E");
			width: 17px;
			height: 17px;
			transform-origin: center;
			padding-right: 0 !important;
			transition: all 0.25s ease;
		}

		tr.has-description:hover .course-title:before,
		tr.has-description.toggled .course-title:before {
			cursor: pointer;
			transform: rotate(45deg);
		}



		.course-title { width: 10%; padding: .5em .75em;}
		.semester { width: 1%; max-width: 11ch; padding: .5em .75em;}
		.ects { width: 1%; max-width: 7ch; padding: .5em .75em;}
		.floor-room { width: 1%; max-width: 15ch; padding: .5em .75em;}
		.lecture-time { width: 10%; padding: .5em .75em;}
		.download-pdf { width: 1%; max-width: 14ch; padding: .5em .75em; vertical-align: center; text-align: center; }
		.short-description { width: 100%; padding: 0 .75em; max-height: 0em; min-height: 0em;  overflow: hidden; border: 0; transition: ease .25s all; border-color: rgba(0,0,0,.1); }
		.short-description.open { padding: .5em .75em; max-height: unset; min-height: 2em; border-bottom: rgba(0,0,0,.1) 1px solid; border-right: rgba(0,0,0,.1) 1px solid;}
		

		</style>

		<table class="course-table parent">
		<thead>
		<tr scope="row" class="header-row">
		<th scope="col" id="course-title" class="course-title"><?php _e('Naziv'); ?></th>
			<th scope="col" id="semester" class="semester"><?php _e('Semestar'); ?></th>
			<th scope="col" id="ects" class="ects"><?php _e('ECTS'); ?></th>
			<th scope="col" id="floor-room" class="floor-room"><?php _e('Kat/Prostorija'); ?></th>
			<th scope="col" id="lecture-time" class="lecture-time"><?php _e('Termin'); ?></th>
			<th scope="col" id="download-pdf" class="download-pdf"><?php _e('Detaljni opis'); ?></th>
			<th scope="col" id="short-description" class="short-description"><?php _e('Kratki opis'); ?></th>
		</tr>
		</thead>
		<tbody>

		<?php while ( $query_courses->have_posts() ) :
			$query_courses->the_post();
			?>
		<tr scope="row" class="course-content <?php if ( get_field( 'kolegij_cpt_opis_kolegija' ) ) : echo esc_attr( 'has-description' ); endif; ?>">
			<td headers="course-title" class="course-title"><?php the_title(); ?></td>
			<td headers="semester" class="semester"><?php the_field('kolegij_cpt_semestar'); ?></td>
			<td headers="ects" class="ects"><?php the_field('kolegij_cpt_ects'); ?></td>
			<td headers="floor-room" class="floor-room"><?php the_field('kolegij_cpt_kat'); ?><?php echo esc_html( '/' ); ?><?php the_field('kolegij_cpt_broj_ucionice'); ?></td>
			<td headers="lecture-time" class="lecture-time"><?php the_field('kolegij_cpt_vrijeme_odrzavanja'); ?></td>
			<td headers="download-pdf" class="download-pdf"><a class="gb-button gb-button-10c4aba4 gb-button-text gb-button-outline-S" href="<?php the_field('kolegij_cpt_dip'); ?>">Preuzmi pdf</a></td>
			<td headers="short-description" class="short-description"><?php the_field('kolegij_cpt_opis_kolegija'); ?></td>
		</tr>
		<?php	endwhile; ?>
				</tbody>
			</table>
		<?php	endif;
	wp_reset_postdata();
	$output = ob_get_clean();
	return $output;
	}
}
add_shortcode( 'apuri_courses', 'apuri_course_table' );