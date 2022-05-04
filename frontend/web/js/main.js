jQuery(document).ready(function () {
    jQuery('.click-close-mmb').on('click', function () {
        jQuery('.mobile-menu-block').hide();
    });

    jQuery('.mobile-menu').on('click', function () {
        jQuery('.mobile-menu-block').show();
    });
});