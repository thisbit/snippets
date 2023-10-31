document.addEventListener('DOMContentLoaded', function() {
  // Select the overlay element
  const overlay = document.querySelector('.overlay');

  // Set a timeout to show the overlay after 5.5 sec
  setTimeout(() => {
    if (!overlay) return; // Bail if overlay doesn't exist
    overlay.classList.add('show');
  }, 5500);

  // Function to set the cookie
  function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  // Function to get the cookie value
  function getCookie(cname) {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i].trim();
      if (c.indexOf(name) === 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  // Check if the cookie 'overlayHider' is set to 'not' and overlay element exists
  const overlayHider = getCookie('overlayHider');
  if (overlayHider === 'not' && overlay) {
    overlay.classList.add('not');
  }

  // Select the closer element
  const closer = document.querySelector('.close');
  if (!closer) return; // Bail if closer doesn't exist

  // Add click event listener to the closer element
  closer.addEventListener('click', function() {
    if (!overlay) return; // Bail if overlay element doesn't exist
    overlay.classList.add('not');
    setCookie('overlayHider', 'not', 30); // Set the cookie 'overlayHider' to 'not' for 30 days
  });
});