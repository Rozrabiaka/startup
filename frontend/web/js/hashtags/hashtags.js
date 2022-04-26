jQuery(document).ready(function () {
    const tagInput = jQuery('.input_hashtags input').show();
    let selectedTags = [];

    jQuery('.hashtags').autocomplete({
        appendTo: '#autocomplete-container',
        source: function (request, response) {
            jQuery.ajax({
                url: '/ajax/search-hashtags',
                type: "GET",
                data: {"hashtag": request.term},
                success: function (data) {
                    if (data) {
                        let autocomplete = {};
                        const result = jQuery.parseJSON(data);
                        jQuery.each(result, function (arKey, arValue) {
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
            if (ui.item.label) {
                const hashtag = ui.item.label;
                const span = '<div class="hashtag-span">' + hashtag + '<span class="hashtag-span-remove" id="' + ui.item.id + '"><img src="/images/svg/remove.svg" alt="remove image"/></span></div>';

                jQuery(".input_hashtags .form-group").prepend(span);
                tagInput.css(
                    'width', '34px'
                );

                selectedTags.push({
                    'id': ui.item.id,
                    'value': ui.item.label
                });
            }

        }, minLength: 3,
        close: function () {
            jQuery('.hashtags').val("");
            jQuery('.input_hashtags input').css(
                'width:34px !important;'
            );
        },
    });

    jQuery(document).on('click', '.hashtag-span-remove', function () {
        const id = jQuery(this).attr('id');
        jQuery('#' + id).parent().remove();

        selectedTags = selectedTags.filter(function (elem) {
            return elem.id !== id;
        });
    });

    jQuery('#create-history-form').submit(function () {
        tagInput.hide();
        if(selectedTags.length > 0) tagInput.val(JSON.stringify(selectedTags));
        else tagInput.show();
    });
});