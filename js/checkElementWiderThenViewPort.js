/** 
 * This code is useful for debugging horizontal scroll appearing on page.
 * include this in page, and open concole to see which elements are causing the scroll 
 */

let docWidth = document.documentElement.offsetWidth;

[].forEach.call(
  document.querySelectorAll('*'),
  function(el) {
    if (el.offsetWidth > docWidth) {
      console.log(el);
    }
  }
);
