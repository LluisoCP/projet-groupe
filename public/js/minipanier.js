jQuery.noConflict();
console.log('jQuery is charged');
$(document).ready(function($) {
    $('#toggle-panier').on('click', function() {
        $('#minipanier-content').slideToggle(200);
    });
});