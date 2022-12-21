/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

const navbarButton = document.querySelector('.navbar-button')
const navbarList = document.querySelector('.nav-list')

navbarButton.addEventListener('click', () => {
    navbarList.classList.contains('hidden')
        ? navbarList.classList.replace('hidden', 'block')
        : navbarList.classList.replace('block', 'hidden')
})

const carouselImages = document.querySelectorAll('.carousel-item')

setInterval(() => {
    let activeImageID =  -3;
    let nxtImg;
    for (let i = 0; i < carouselImages.length; i++) {
        const chkImg = carouselImages[i];
        if (chkImg.classList.contains('active')) {
            activeImageID = i;
            nxtImg = activeImageID + 1;
        }

        if (nxtImg >= carouselImages.length) {
            nxtImg = 0;
        }
    }

    carouselImages[activeImageID].classList.replace('active', 'inactive');
    carouselImages[nxtImg].classList.replace('inactive', 'active');
}, 5000)
