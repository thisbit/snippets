/**
 * Script Name: JS Live Search and Filter feature
 * Description: This script provides Vanilla JS filtering and search capability, for a CPT listing Page. It has a fallback to PhP filter for browsers that do not support JS. The JS filter has no Depemndencies but it is limited to filtering and searching elements allreadz in the DOM. It does not fetch anything from DB. The advantage of this filter is speed and UX friendlyness.
 * Original idea and code is from here @link https://codepen.io/hilmanski/pen/XWgZYYp?editors=1010 which I extended with fallback and filtering.
 * 
 * TOC
 * - DOM ELEMENTS
 * -- fix tabordering
 * - FUNCTION DEFINITIONS
 * -- Toggle Section Headers
 * -- Live search
 * -- Filters
 * - FUNCTION EXCUTIONS
 * -- Filters
 * -- Search
 * 
 * NOTICE: 
 * - For this to work you have to wrap both Filters and QueryBlock in one container and add class .main-filter-query-wrapper to it
 * - If you want to show hide section title depending on weathere there are results in the search or filter add .loop to container holding heading and queryblock
 * - If you want to use sticky filters feature add .sticky class to contener in which shortcode block is
*/

window.addEventListener( "DOMContentLoaded", () => {

	/******************** DOM ELEMENTS *******************/

	const skipLink        = document.querySelector( ".skip-link" );
	const primaryNavLinks = document.querySelectorAll( ".menu-item a" );
	const homeLink        = document.querySelector( ".site-logo a" );
	
	const mainWrapper    = document.querySelector( ".main-filter-query-wrapper" ); // ADD THIS CLASS TO MAIN CONTAINER IN THE GUTENBERG EDITOR
	const cards          = mainWrapper.querySelectorAll( ".hentry" );
	const cardLinks		   = mainWrapper.querySelectorAll( ".gb-container-link" );
	const filterMenu		 = mainWrapper.querySelector( ".apuri-filter-menu" );
	
	const filterButtons  = filterMenu.querySelectorAll( ".filter" );
	const resetFilters   = filterMenu.querySelector( ".reset-filters" );
	const searchReset    = filterMenu.querySelector( ".search-reset" );
	const searchInput    = filterMenu.querySelector( "#searchbox" );
	const sticky         = mainWrapper.querySelector( ".sticky" ); // ADD THIS CLASS IF YOU WANT TO USE STICKY FILTERS FEATURE
	
	cards.forEach( element => element.classList.add( "is-visible" ) );

	// fix tabordering
	skipLink.setAttribute( "tabindex", 1 );
	homeLink.setAttribute( "tabindex", 1 ); // maknuti na pravom sajtu
	primaryNavLinks.forEach( element => element.setAttribute( "tabindex", 1 ) );
	cardLinks.forEach( element => element.setAttribute( "tabindex", 3 ) );

	/******************** FUNCTION DEFINITIONS *******************/

	/**
	 * Toggle Section Headers based on having or not having Content in
	 */
	function toggleSectionHeadings() {
		const sections = document.querySelectorAll( ".loop" ); // ADD THIS CLASS TO CONTAINER THAT HOLDS THE SECTION HEADER AND QUERY BLOCK
		if ( sections ) {
			sections.forEach( (section) => {
				if ( section.querySelectorAll(".cards .is-visible").length <= 0 ) {
					section.classList.add( "is-hidden" );
				} else {
					section.classList.remove( "is-hidden" );
				}
			}, false );
		}
	}

	/**
	 * Live search shows and hides cards
	 */
	function liveSearch() {
		let searchQuery = document.getElementById( "searchbox" ).value;
		//Use innerText if all contents are visible
		//Use textContent for including hidden elements
		for ( let i = 0; i < cards.length; i++ ) {
			if ( cards[i].textContent.toLowerCase().includes(searchQuery.toLowerCase()) ) {
				cards[i].classList.remove( "is-hidden" );
				cards[i].classList.add( "is-visible" );
				toggleSectionHeadings();
			} else {
				cards[i].classList.add( "is-hidden" );
				cards[i].classList.remove( "is-visible" );
				toggleSectionHeadings();
			}
		}
	}

	/**
	 * Filters show and hide the cards too
	 */
	function filterCards( katedra ) {
		
		// ux feedback for filters
		let ifActive = Array.from( filterMenu.querySelectorAll( ".active" ) );
		ifActive.forEach( element => element.classList.remove( "active" ) );

		// actual filtering
		for (let i = 0; i < cards.length; i++) {
			searchInput.value = ""; // first clean search in case its not empty
			
			if ( cards[i].classList.contains( katedra ) ) { // if you belong to my collection
				cards[i].classList.remove( "is-hidden" );
				cards[i].classList.add( "is-visible" );
				toggleSectionHeadings();
			} else if ( ! cards[i].classList.contains( katedra ) ) { // if you are not in my collection
				cards[i].classList.add( "is-hidden" );
				cards[i].classList.remove( "is-visible" );
				toggleSectionHeadings();
			}
			// if one clicks on filter reset, reveal all cards
			resetFilters.addEventListener( "click", () => { 
				cards[i].classList.remove( "is-hidden" );
				cards[i].classList.add( "is-visible" );
				filterButtons.forEach( (item) => { item.classList.remove( "active" ); });  
				resetFilters.classList.add( "active" );
				toggleSectionHeadings();
			} );
			// keyboard too
			resetFilters.addEventListener( "keyup", ( event ) => { 
				if ( event.key === "Enter" ) {
					cards[i].classList.remove( "is-hidden" );
					cards[i].classList.add( "is-visible" );
					filterButtons.forEach( (item) => { item.classList.remove( "active" ); });  
					resetFilters.classList.add( "active" );
					toggleSectionHeadings();
				}
			});			
		}
	}

	/******************** FUNCTION EXCUTIONS *******************/

		// if the total height of the filter sidebar is less then viewport, make it stick, and keep watching over the height on browser resize
		if ( sticky ) {
			if ( sticky.offsetHeight < window.innerHeight ) { sticky.classList.add("sticky-element"); }
				window.addEventListener( "resize", () => { if ( sticky.offsetHeight < window.innerHeight ) { sticky.classList.add("sticky-element"); } 
				else { sticky.classList.remove("sticky-element"); }
			});
		}

		// mousing filters
		filterButtons.forEach((item) => {
			item.addEventListener('click', (event) => {
				event.preventDefault();
				scrollToTop();
				filterCards( php_vars.apuri_taxonomy + "-" + item.id );
				item.classList.toggle('active');
			});
		});
	
		// keyboard filters
		filterButtons.forEach((item) => {
			item.addEventListener('keyup', (event) => {
				if ( event.key === "Enter" ) {
					event.preventDefault();
					scrollToTop();
					filterCards( php_vars.apuri_taxonomy + "-" + item.id );
					item.classList.toggle('active');
				}
			});
		});

	// Search
	let typingTimer;               
	let typeInterval = 500;

	searchInput.addEventListener( "keyup", () => {
		clearTimeout( typingTimer );
		typingTimer = setTimeout( liveSearch, typeInterval, scrollToTop() );
	});

	searchReset.addEventListener( "keyup", () => { searchInput.value = ""; });


	
	// scroll to top
	function scrollToTop() {
		if ( window.pageYOffset > window.innerHeight / 3 ) { // do not scroll if there is no reason
			window.scroll({top: 240, left: 0, behavior: "smooth" });
		}
	}
}, false );