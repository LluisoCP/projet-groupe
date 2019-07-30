jQuery.noConflict();

console.log('jQuery is charged');
$(document).ready(function($) {
    $('#toggle-panier').on('click', function() {
        let a = $(this).text();
        console.log(a);
        $('#minipanier-content').slideToggle(200);
    });
});