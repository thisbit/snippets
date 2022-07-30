// Modern E6 itterator
// here used to check for js in browser
// since we are providing fallback, we dont care weather < IE11 can understand this. But do not use this in the context where IE is important.

window.addEventListener( "DOMContentLoaded", () => {
    const jsOrNot = Array.from(document.querySelectorAll( ".js-or-not" ));
    jsOrNot.forEach( element => element.classList.toggle( "hide-me" ) );
}, false );