// prijevod arhiv paginacije
add_filter( 'generate_next_link_text', function() {
	if ( get_locale() !== 'en_US' ) :
		return 'Sljedeće <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36"><path d="m29 19-8 8m8-8H6m23 0-8-8" stroke-width="2.3"/></svg>';
	endif;
} );

add_filter( 'generate_previous_link_text', function() {
	if ( get_locale() !== 'en_US' ) :
		return '<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36"><path d="m8 17 7-8m-7 8h22M8 17l7 8"  stroke-width="2.3"/></svg> Prethodno';
	endif;
} );

// Custom apuri styles
<style>
	
	/* search and archive navigation */

	.paging-navigation .nav-links {
		height: 5rem;
		font-size: var(--apuri-type-small);
		display: flex;
		width: 100%;
		flex-direction: row;
		flex-wrap: wrap;
		align-content: center;
		align-items: center;
		border-top: solid var(--primary-dark) 1px;
		border-bottom: solid var(--primary-dark) 1px;
		margin-top: var(--apuri-vspace-medium);
	}

	.paging-navigation .nav-links .page-numbers {
		padding: 1em;
	}

	.paging-navigation .nav-links .page-numbers:first-child  {
		padding-left: 0;
	}
	.paging-navigation .nav-links .page-numbers:last-child  {
		padding-right: 0;
	}

	.paging-navigation .nav-links .prev {
		margin-right: auto;
		display: flex;
		align-items: center;
		padding-right: 0;
	}

	.paging-navigation .nav-links .next {
		margin-left: auto;
		display: flex;
		align-items: center;
		padding-left: 0;
	}

	.paging-navigation .nav-links .current {
		font-weight: unset;
	}

	.paging-navigation .nav-links svg {
		height: 1em;
		display: none;
	}

	@media ( min-width: 62rem ) {
		.paging-navigation .nav-links .prev {
			margin-left: -3.5rem;
		}

		.paging-navigation .nav-links .next {
			margin-right: -3.5rem;
		}

		.paging-navigation .nav-links .prev svg {
			padding-right: 2rem;
		}
		
		.paging-navigation .nav-links .next svg {
			padding-left: 2rem;
		}
		
		.paging-navigation .nav-links svg {
			height: 1em;
			display: unset;
		}
		.paging-navigation .nav-links svg path {
			stroke: var(--primary-dark);
		}
	}
</style>