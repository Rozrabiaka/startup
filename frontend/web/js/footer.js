jQuery(document).ready(function () {
    const up = jQuery('.up');
    const down = jQuery('.down');
    const footerC = jQuery('.footer-c');

    jQuery(".up").click(function () {
        up.hide();
        down.show();
        footerC.show();
    });

    jQuery(".down").click(function () {
        down.hide();
        up.show();
        footerC.hide();
    });
});