// A Button that scrolls the page down from section to section smoothly
// Button needs to be positioned absolutely and design using css or a builder
// Here is the demo of this button in use https://youtu.be/_JZ9k0kT7yY?t=382

window.addEventListener('DOMContentLoaded', () => { 
    const button = document.querySelector('.carret-down');
    const sections = document.querySelectorAll('.custom-section');
     
    function* goToNextSection(event) { 
        let i = 1, max = sections.length;
        while (true) {
            yield event[i++]
            i %= max;
        }
    }
    const buttonClicked = goToNextSection(sections);

    button.addEventListener('click', () => { 
        buttonClicked.next().value.scrollIntoView({ behavior: "smooth", block: "center"});
        }
    );
});