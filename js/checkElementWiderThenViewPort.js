/** 
 * This code is useful for debugging horizontal scroll appearing on page.
 * open web dev console and paste this line inside, it will outline the elements with thick red line and list them in console as well
 */

[...document.querySelectorAll('*')].forEach(el => { if (el.scrollWidth > el.clientWidth) { el.style.outline = '2px solid red'; console.log(el); } });
