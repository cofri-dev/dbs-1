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

$('.slide').owlCarousel({
    loop: false,
    autoplay: false,
    nav: false,
    dots: false,
    autoplayTimeout: 3000,
        responsive: {
            0: {
            items: 1
            },
            600: {
            items: 3
            },
            1000: {
            items: 3
            }
        }
})
