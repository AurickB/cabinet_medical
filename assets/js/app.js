/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
const $ = require('jquery');
/** Gestion de la navbar responsive */

class DOMAnimation  {
    /**
     * Masque un élément avec un effet de repli
     * @param {HTMLElement} element
     * @param {Number} duration
     */
    static slideUp (element, duration = 500) {
        element.style.height = element.offsetHeight + 'px'; // on précise la valeur
        element.style.transitionProperty = `height, margin, padding`;
        element.style.transitionDuration = duration + 'ms';
        element.offsetHeight; // on force le redessin
        element.style.overflow = 'hidden';
        element.style.height = 0;
        element.style.paddingTop = 0;
        element.style.paddingBottom = 0;
        element.style.marginTop = 0;
        element.style.marginBottom = 0;
        window.setTimeout(function () {// on lance cette fonction a la fin de la durée de l'animation
            element.style.display = 'none';
            // on enlève tous les styles afin de nettoyer l'html
            element.style.removeProperty('height');
            element.style.removeProperty('padding-top');
            element.style.removeProperty('padding-bottom');
            element.style.removeProperty('margin-top');
            element.style.removeProperty('margin-bottom');
            element.style.removeProperty('overflow');
            element.style.removeProperty('transition-duration');
            element.style.removeProperty('transition-property');
        }, duration)
    }
    /**
     * Affiche un élément avec un effet de dépliement
     * @param {HTMLElement} element
     * @param {Number} duration
     */
    static slideDown (element, duration = 500) {
        element.style.removeProperty('display'); // on enlève la propriete par default
        let display = window.getComputedStyle(element).display;
        if (display === 'none') display = 'block';
        element.style.display = display;
        let height = element.offsetHeight;
        element.style.overflow = 'hidden';
        element.style.height = 0;
        element.style.paddingTop = 0;
        element.style.paddingBottom = 0;
        element.style.marginTop = 0;
        element.style.marginBottom = 0;
        element.offsetHeight; // on force le redessin
        element.style.transitionProperty = `height, margin, padding`;
        element.style.transitionDuration = duration + 'ms';
        element.style.height = height + 'px';
        element.style.removeProperty('padding-top');
        element.style.removeProperty('padding-bottom');
        element.style.removeProperty('margin-top');
        element.style.removeProperty('margin-bottom');
        window.setTimeout(function () {
            element.style.removeProperty('height');
            element.style.removeProperty('overflow');
            element.style.removeProperty('transition-duration');
            element.style.removeProperty('transition-property')
        }, duration)
    }

    /**
     * Affiche ou Masque un élément avec un effet de repli
     * @param {HTMLElement} element
     * @param {Number} duration
     * @returns {Promise<boolean>}
     */
    static slideToggle (element, duration = 500) {
        if (window.getComputedStyle(element).display === 'none') {
            return this.slideDown(element, duration)
        } else {
            return this.slideUp(element, duration)
        }
    }

    static displayScrollMenu(element1, element2){
        let acc = element1;
        let accItem = element2;
        let i;
        // On parcours tous les titres.
        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                // On crée une variable qui renvoie la valeur du noeud parent.
                let itemClass = this.parentNode.className;
                /**
                 * Au click sur le titre d'un élément accordéon,
                 * On réduit tout les éléments accordéon.
                 */
                for (i = 0; i < accItem.length; i++) {
                    accItem[i].className = 'accordion-item closed';
                    console.log("close")
                }
                // Si au click le noeud parent à pour class "close" alors il récupère la class "open".
                if (itemClass == 'accordion-item closed') {
                    this.parentNode.className = 'accordion-item open';
                    console.log("open")
                }
            });
        }
    }

    static navToggle(){
        $('#menu-toggle').click(function () {
            $('#content').toggleClass('is-opened');
        });
        // Fermer le menu responsive au click sur un élément du menu.
        $('#navbar ul li a').click(function () {
            $('#menu-toggle:visible').click();
        });
    }

    static scrollTo(){
        $('.js-scrollTo').on('click', function () {
            if (location.hostname == this.hostname
                && this.pathname.replace(/^\//, "") == location.pathname.replace(/^\//, "")){
                let target = getHashFromUrl(this);
                $('html, body').stop().animate({ scrollTop: $(target).offset().top }, 'slow');
                return false;
            }
        });
    }
}

function getHashFromUrl(url){
    return $("<a />").attr("href", url)[0].hash;
}

function init(){
    DOMAnimation.navToggle();
    DOMAnimation.displayScrollMenu(document.getElementsByClassName("accordion-item-heading"), document.getElementsByClassName('accordion-item'));
    DOMAnimation.scrollTo();
}

window.onload = init();


console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
console.log(window.location);