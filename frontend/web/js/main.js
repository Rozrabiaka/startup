jQuery(document).ready(function () {
    const q = jQuery('#q');
    const up = jQuery('.up');
    const down = jQuery('.down');
    const footerC = jQuery('.footer-c');

    jQuery('.click-close-mmb').on('click', function () {
        jQuery('.mobile-menu-block').hide();
    });

    jQuery('.mobile-menu').on('click', function () {
        jQuery('.mobile-menu-block').show();
    });

    q.autocomplete({
        // appendTo: '#autocomplete-container',
        source: function (request, response) {
            jQuery.ajax({
                url: '/ajax/search',
                type: "GET",
                data: {"q": request.term},
                success: function (data) {
                    if (data) {
                        let autocomplete = {};
                        const qResult = jQuery.parseJSON(data);
                        jQuery.each(qResult, function (arKey, arValue) {
                            autocomplete[arValue.id] = {
                                'label': arValue.name,
                                'id': arValue.id
                            }
                        });
                        response(autocomplete);
                    }
                }
            });
        },
        select: function (event, ui) {


        }, minLength: 3,
        close: function () {

        },
    });

    jQuery(".up").click(function () {
        down.show();
        footerC.show();
        up.hide();
    });

    jQuery(".down").click(function () {
        down.hide();
        up.show();
        footerC.hide();
    });
});