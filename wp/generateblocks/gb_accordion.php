<?php
/** Design your own Accordions
 * This is old, I have a newer version using buttons which then allows for better accessibility, will update soon
 * this snippet contains basic functionality at the moment I will develop it further, so drop by again in a while
*/
function thisbit_accordion_script() { ?>
<script id="toggler">

// Reusable function for togglig one ore more elements in a page.
// Add the class click-me to elements you want to triger the clicking.
// This element needs to be placed just before thelement you want to show-hide.

// Run function after DOM has loaded.
window.addEventListener("DOMContentLoaded", (event) => {
  // target all the trigers and store them as array.
  const buttons = Array.from(document.querySelectorAll(".click-me"));

  // Handle the state changes.
  function toggle(triggers) {
    const handleClick = (event) => {
      event.preventDefault(); // If actually a button or a link
      event.currentTarget.classList.toggle("toggled");
      event.currentTarget.nextElementSibling.classList.toggle("open");
    };

    // Run the function on select elements.
    const clicker = buttons.forEach((element) => {
      element.addEventListener("click", handleClick, false);
    });

    return clicker;
  }
  // Do the toggling.
  toggle(buttons);
});
</script>
<?php }
add_action( 'wp_head', 'thisbit_accordion_script');


function thisbit_accordion_style() { ?>
<style id="gb-accordion-style">
.click-me {
  cursor: pointer;
  user-select: none;
}
	
.click-me:hover,
.click-me.toggled {
  color: #5b5b5b;
}
	
.click-me .gb-icon {
	transform-origin: center;
	padding-right: 0 !important;
	transition: all 0.5s ease;
}

.click-me:hover .gb-icon,
.click-me.toggled .gb-icon{
	color: #5b5b5b;
	transform: rotate(-90deg);
}
	
.click-me .gb-headline-text {
	padding-left: 1em;
}


.click-me + * {
	opacity: 0;
	height: 0;
	overflow: hidden;
	transition: all 0.5s ease;

}

.click-me + .open,
.click-me + .open * {
	opacity: 1;
	height: min-content;
	}

</style>
<?php }
add_action( 'wp_head', 'thisbit_accordion_style');