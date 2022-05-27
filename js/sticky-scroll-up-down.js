/** 
 * A better scroll watcher
 * @link https://gist.github.com/yankiara/6984c41af9e7b5463a1d169b9fb40114
*/
window.addEventListener( 'DOMContentLoaded', ()=> {

	const	body = document.body,
		  	scrollUp = "up",
		  	scrollDown = "down",
		  	offset = 0;
	let 	lastScroll = window.pageYOffset;

	if ( lastScroll > offset ) {
		body.classList.add(scrollUp);
	}

	window.addEventListener('scroll', ()=> {

		const currentScroll = window.pageYOffset;
		
		if ( currentScroll <= offset ) {
			body.classList.remove(scrollUp);
			return;
		}
		if ( currentScroll > lastScroll && !body.classList.contains(scrollDown) ) {
			body.classList.remove(scrollUp);
			body.classList.add(scrollDown);
		} else if ( currentScroll < lastScroll && !body.classList.contains(scrollUp) ) {
			body.classList.remove(scrollDown);
			body.classList.add(scrollUp);
		}
		lastScroll = currentScroll;

	})

});