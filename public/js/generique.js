
/************************************************************************************************************************/
/****************************************************** VARIABLES *******************************************************/
/************************************************************************************************************************/

// booleen qui détermine quelle fonction à lancer en fonction de la 
// taille de l'écran
var vueMobile;
var vueTablette;
var vueDesktop;

// récupération de la largeur de l'écran
var viewWidth = $(window).width();






/************************************************************************************************************************/
/****************************************************** ACTIVATION ******************************************************/
/************************************************************************************************************************/


// au resize on vérifie la taille de l'écran
$(window).on("resize",function() {
	checkSize();
});


// READY function
$(document).ready(function() {

	// au chargement on vérifie la taille de l'écran
	checkSize();

});






/************************************************************************************************************************/
/****************************************************** FONCTIONS *******************************************************/
/************************************************************************************************************************/

// verification de la taille de l'ecran pour determiner quelle fonction appeler
function checkSize() {

    // controle de la taille 
    // si la taille de l'ecran est inferieur a 1024 -> version mobile
    if ($(window).width() < 768) {	 
        vueMobile = true;
        vueTablette = false;
        vueDesktop = false;
    } 
    // si la taille de l'ecran est inferieur entre 768 et 1024 -> version tablette
    else if (($(window).width() < 1024) && ($(window).width() >= 768)){
        vueMobile = false;
        vueTablette = true;
        vueDesktop = false;
    }
    // si la taille de l'ecran est supérieur a 1024 -> version desktop
    else if ($(window).width() >= 1024) {
        vueMobile = false;
        vueTablette = false;
        vueDesktop = true;
    } 
}