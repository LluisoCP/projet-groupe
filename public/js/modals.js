$.noConflict();
jQuery(document).ready(function ($) {
    const triggers = $('.triggers'),
        cancel = $('#cancel'),
        deleter = $('#delete'),
        modal = $('#modal');

    triggers.click(function () {
        let next = $(this).data("target");
        modal.fadeIn(200, function () {
            deleter.attr("href", next);
        })
    });
    cancel.click(function () {
        modal.fadeOut(200, function () {
            deleter.attr("href", "");
        });
    })
    jQuery(document).on('keyup', function (e) {
        if ((e.key == "Escape" || e.key == 27) && modal.css('display') == 'block') {
            modal.fadeOut(200, function () {
                deleter.attr("href", "");
            });
        }
    });

})