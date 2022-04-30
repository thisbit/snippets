// Modern E6 itterator
// here used to check for js in browser
// since we are providing fallback, we dont care weather < IE11 can understand this. But do not use this in the context where IE is important.

window.addEventListener( "DOMContentLoaded", (event) => {

	const noJS    = Array.from(document.querySelectorAll(".no-js"));
	const needsJS = Array.from(document.querySelectorAll(".needs-js"));

	const needsJS = Array.from(document.querySelectorAll(".needs-js"));

	noJS.forEach( element    => element.classList.add( "hide-me" ) );
	needsJS.forEach( element => element.classList.remove( "hide-me" ) );

}, false );