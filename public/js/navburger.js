const navContainer = document.querySelector("nav")
const navOpen = document.querySelector(".nav--open")
let animationIsPlaying = false;

navOpen.addEventListener("click", function() {
    console.log(
         "click"
    )
    navContainer.classList.toggle("active") 
    navOpen.classList.toggle("active") 
    if (animationIsPlaying) {
        navOpen.classList.add('reverse');
    } else {
          navOpen.classList.remove('reverse');
      }
      animationIsPlaying = !animationIsPlaying;
})