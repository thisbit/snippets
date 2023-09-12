<?php
/**
* Back to Top button that appears once one scrolls past the full viewport height
* Drop this function into your functions.php, code snippets plugin ...
* You should not need to change anything, but in case your theme does not have #page id in one of top dom elements, change to the one you have
* CSS you can normally edit as you like
*/

function back_to_top() {
	?>
	<style id="back-to-top">
	html{
        scroll-behavior:smooth;
    }
	.back-to-top,
    .back-to-top.above{
        display:none;    }
	
    .back-to-top.under{
        display:flex;
    }
    
    .back-to-top{
        background:gray;
        align-items:center;
        justify-content:center;
        padding:1rem;
        width:fit-content;
        position:fixed;
        bottom:2rem;
        right:2rem;
        border-radius:3px;
    }
    .back-to-top svg{
        height:18px;
        width:18px;
    }

	</style>
	<!-- if html of your theme does not have #page ID in one of top containers, change to the ID that it has -->
	<a href="#page" 
	    class="back-to-top">
	    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 4"><path fill="#000" d="M.7 3.4v-.2l3.1-3L4 0l3.1 3.1.1.2v.1l-.4.4h-.2L4 1.3 1.4 3.9H1l-.4-.4v-.1Z"/></svg>
	</a>
	<script type="text/javascript" id="back-to-top">let button=document.querySelector(".back-to-top"),previousScrollPosition=0;const hasScrolledPast=()=>{let t=!1;return window.pageYOffset>window.innerHeight&&(t=!0),t},handleScroll=t=>{hasScrolledPast()?(button.classList.add("under"),button.classList.remove("above")):(button.classList.add("above"),button.classList.remove("under"))};setTimeout(()=>{window.addEventListener("scroll",handleScroll)},100);
	</script>
	<?php
}
add_action( 'wp_footer', 'back_to_top' );