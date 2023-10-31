<?php

/**
* This function removes all title attributes it finds in the document, links, images ... or any other element
* Basically do not use this function, it is not a very good idea, I am puting it here for safekeeping, because client wanted
*/

function thisbit_remove_title_attr(){
	?>
	 <script type="text/javascript" id="remove-titles">
		function removeAltAtrr() {
	    //get the images
	    let getTitles = document.querySelectorAll("[title]"); 
	     
	    //loop through all images
	    for (let i = 0; i < getTitles.length; i++) {  
	        getTitles[i].removeAttribute("title");   
			}
		}
		removeAltAtrr();
	 </script>
	<?php
	}
	add_action('wp_footer', 'thisbit_remove_title_attr', 9999);