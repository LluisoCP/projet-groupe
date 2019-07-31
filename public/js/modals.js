$.noConflict();
jQuery(document).ready(function ($) {
    const forms = $('.form'),
          cancel = $('#cancel'),
          deleter = $('#delete'),
          modal = $('#modal');

    forms.submit(function (e) {
        e.preventDefault();
        $(this).addClass('send');
        modal.fadeIn(200);
    });
    cancel.click(function () {
        modal.fadeOut(200, function () {
            $('form.send').removeClass('send');
        });
    })
    $(document).on('keyup', function (e) {
        if ((e.key == "Escape" || e.key == 27) && modal.css('display') == 'block') {
            modal.fadeOut(200, function () {
                $('form.send').removeClass('send');
            });
        }
    });
    deleter.click(function(){
        modal.fadeOut(200, function() {
            $('form.send').submit()
            $('form.send').removeClass('send'); //cal?
        })
    })
})