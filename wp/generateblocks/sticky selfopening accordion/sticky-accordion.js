// this is an experiment, not sure how good it is from the perspective of UX

document.addEventListener("DOMContentLoaded", function () {
  var header = document.querySelector(".thisbit-custom-header");
  var elements = document.querySelectorAll(".gb-accordion__item");
  var activeElement = null;

  function handleScroll() {
    var scrollPosition = window.scrollY;
    var headerPosition = header.offsetHeight + 2; // Add 2 pixels to header height

    for (var i = elements.length - 1; i >= 0; i--) {
      var element = elements[i];
      var elementPosition = element.offsetTop;

      if (scrollPosition >= elementPosition - headerPosition) {
        if (activeElement !== element) {
          if (activeElement) {
            activeElement.classList.remove("gb-accordion__item-open");
          }
          activeElement = element;
          activeElement.classList.add("gb-accordion__item-open");
        }
        break;
      }
    }
  }

  window.addEventListener("scroll", handleScroll);
});