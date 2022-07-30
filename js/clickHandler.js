/**
 * Toggle functionality
 * Depends on CSS to do the styling
*/
window.addEventListener("DOMContentLoaded", (event) => {
  const buttons = Array.from(document.querySelectorAll(".click"));

  function toggle(triggers) {
    const handleClick = (event) => {
      event.preventDefault();
      event.currentTarget.classList.toggle("toggled");
      event.currentTarget.nextElementSibling.classList.toggle("open");
    };

    const clicker = buttons.forEach((element) => {
      element.addEventListener("click", handleClick, false);
    });

    return clicker;
  }
  toggle(buttons);
});