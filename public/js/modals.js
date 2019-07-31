$.noConflict();
jQuery(document).ready(function ($) {
    const   forms = $('.form'),
            cancel = $('#cancel'),
            deleter = $('#delete'),
            modal = $('#modal');



    forms.on('submit', lancer);

    function lancer(e) {
        console.log('Formulaire pre-envoyé.')
        e.preventDefault();
        $(this).addClass('send').off('submit', lancer);
        modal.fadeIn(200);
    }

    cancel.click(function () {
        console.log('Envoi annulé.')
        modal.fadeOut(200, function () {
            $('form.send').removeClass('send').on('submit', lancer);
        });
    })
    $(document).on('keyup', function (e) {
        if ((e.key == "Escape" || e.key == 27) && modal.css('display') == 'block') {
            modal.fadeOut(200, function () {
                $('form.send').removeClass('send').on('submit', lancer);
            });
        }
    });
    deleter.click(function(){
        modal.fadeOut(200, function() {
            $('form.send').submit()
        });
    });
});