$.noConflict();
jQuery(document).ready(function ($) {
    //code here
    $(function () {
        $("#accordion").accordion({
            header: "h3",
            collapsible: true,
            active: false,
            icons: { "header": "ui-icon-triangle-1-s", "activeHeader": "ui-icon-triangle-1-n" }
        });
    });
})