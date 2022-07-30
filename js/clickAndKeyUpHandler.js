/**
 * Accessible toggle functionality 
 * depends on CSS to do the styling
*/
window.addEventListener("DOMContentLoaded", (event) => {
	const buttons = Array.from(document.querySelectorAll(".has-description"));

	function toggle(triggers) {
		
		// clicking
		const handleClick = (event) => {
			event.preventDefault();
			event.currentTarget.classList.toggle("toggled");
			if ( event.currentTarget.ariaExpanded == 'false'  ) {
				event.currentTarget.ariaExpanded = true;
			} else {
				event.currentTarget.ariaExpanded = false;
			}
			event.currentTarget.parentNode.lastElementChild.classList.toggle("open");
		};

		// keyboard users
		const handleKeyDown = (event) => {
			if ( event.key === "Enter" ) {
				event.preventDefault();
				event.currentTarget.classList.toggle("toggled");
				if ( event.currentTarget.ariaExpanded == 'false'  ) {
					event.currentTarget.ariaExpanded = true;
				} else {
					event.currentTarget.ariaExpanded = false;
				}
				event.currentTarget.parentNode.lastElementChild.classList.toggle("open");
			};
		}

		// run events
		const clicker = buttons.forEach((element) => {
			element.addEventListener("click", handleClick, false);
			element.addEventListener("keydown", handleKeyDown, false);
		});

		return clicker;
	}	
	toggle(buttons);
});