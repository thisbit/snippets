window.addEventListener("DOMContentLoaded", (event) => {
  const tabSection = Array.from(document.querySelectorAll(".toggle")); // wrapper
  tabSection.forEach((section) => {
    let trigger = section.querySelector(".trigger");
    trigger.setAttribute("tabindex", 0);
    let contentWrapper = section.querySelector('.containers');

    let content = Array.from( contentWrapper.querySelectorAll(".gb-inside-container > .gb-container") );
    content[0].classList.add("is-active");
    content[0].style.height = content[0].scrollHeight + "px";
    
    function toggleEvents(event) {
      event.preventDefault();
      if (event.keyCode === 13 || event.button == 0 ) {
        trigger.classList.toggle("toggled");
        content.forEach((elem) => elem.classList.toggle("is-active"));
         content.forEach( (element) => {
          if ( element.classList.contains("is-active") ) {
            element.style.height = element.scrollHeight + "px";
          } else {
            element.style.height = 0;
          }
        });
      }
    }
      ["click", "keyup"].forEach((event) => trigger.addEventListener(event, toggleEvents));
  });
});