$.noConflict();
jQuery(document).ready(function ($) {
    const   forms = $('.supprimer'),
            cancel = $('#cancel'),
            deleter = $('#delete'),
            modal = $('#modal'),
            vider = $('#vider')
            message = $('#modal h6 span');



    //Modal vider
    vider.click( (e) => {
        e.preventDefault();
        next = vider.attr('href');
        console.log(next);
        message.html('panier');
        deleter.attr('href', next);
        modal.fadeIn(200);
    });
    forms.on('submit', lancer);

    function lancer(e) {
        console.log('Formulaire pre-envoyé.')
        e.preventDefault();
        message.html('produit');
        $(this).addClass('send').off('submit', lancer);
        modal.fadeIn(200);
    }

    cancel.click(function () {
        deleter.attr('href', '#');
        console.log('Envoi annulé.');
        modal.fadeOut(200, function () {
            $('form.send').removeClass('send').on('submit', lancer);
        });
    });
    $(document).on('keyup', (e) => {
        if ((e.key == "Escape" || e.key == 27) && modal.css('display') == 'block') {
            modal.fadeOut(200, () => {
                $('form.send').removeClass('send').on('submit', lancer);
            });
        }
    });
    deleter.click( () => {
        if (deleter.attr('href') == '#') {
            modal.fadeOut(200, () => {
                $('form.send').submit();
            });
        }
    });
});