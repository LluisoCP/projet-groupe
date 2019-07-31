const lien = document.getElementsByClassName('lien');
const resultat = document.getElementsByClassName('resultat');
const recherche = document.getElementById('lance-recherche');

jQuery('.lien').on('mouseover', action);
function action() 
{
    $(this).css('color', 'goldenrod');
}

jQuery('.lien').on('mouseleave', reaction);
function reaction() 
{
    $(this).css('color', 'rgba(253, 249, 40, 0.87)');
}

jQuery(recherche).on('click', affichage);
function affichage()
{
    //jQuery(resultat).empty();
    console.log('message', resultat);
}

