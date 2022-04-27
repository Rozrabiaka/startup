jQuery(document).ready(function () {
    const tagInput = jQuery('.input_hashtags input');
    const hashtags = jQuery('.hashtags');
    const form = jQuery('#create-history-form');
    let selectedTags = [];
    const maxLength = 25;

    hashtags.on("input", function () {
        if (jQuery(this).val().length >= maxLength) {
            hashtags.val(jQuery(this).val().substring(0, maxLength));
        }
    });

    hashtags.autocomplete({
        appendTo: '#autocomplete-container',
        source: function (request, response) {
            let ignore = '';
            if (selectedTags.length > 0) {
                for (let i = 0; selectedTags.length >= i; i++) {
                    if (typeof selectedTags[i] !== 'undefined') {
                        if (i === 0) ignore = selectedTags[i].value;
                        else ignore += ',' + selectedTags[i].value;
                    }
                }
            }

            jQuery.ajax({
                url: '/ajax/search-hashtags',
                type: "GET",
                data: {"hashtag": request.term, 'ignore': ignore},
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
            if (ui.item.label) {
                setNewHashtag(ui.item.label);
            }

        }, minLength: 3,
        close: function () {
            hashtags.val("");
            jQuery('.input_hashtags input').css(
                'width:34px !important;'
            );
        },
    });

    jQuery(document).on('click', '.hashtag-span-remove', function () {
        const id = jQuery(this).attr('id');
        jQuery('#' + id).parent().remove();

        console.log(selectedTags);
        selectedTags = selectedTags.filter(function (elem) {
            return elem.id !== id;
        });

        if (selectedTags.length < 9) {
            hashtags.prop('disabled', false);
            hashtags.show();
        }
    });

    hashtags.keypress(function (event) {
        const keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            setNewHashtag(hashtags.val());
            hashtags.val("");
        }
    });

    function setNewHashtag(label) {

        if (selectedTags.length > 0) {
            for (let i = 0; selectedTags.length >= i; i++) {
                if (typeof selectedTags[i] !== 'undefined') {
                    if (selectedTags[i].value === label) return false;
                }
            }
        }

        if (selectedTags.length == 9) {
            hashtags.prop('disabled', true);
            hashtags.hide();
            return false;
        }

        let id = () => {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        };

        const genId = id();
        const span = '<div class="hashtag-span">' + label + '<span class="hashtag-span-remove" id="' + genId + '"><img src="/images/svg/remove.svg" alt="remove image"/></span></div>';

        label = jQuery.trim(label);
        label = label.replace(/  +/g, ' ');

        if (!label.replace(/\s/g, '').length) return false;
        if (label.length <= 1) return false;

        jQuery(".input_hashtags .form-group").prepend(span);
        tagInput.css('width', '34px');

        selectedTags.push({
            'id': genId,
            'value': label
        });
    }

    form.on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    form.submit(function () {
        tagInput.hide();
        if (selectedTags.length > 0) tagInput.val(JSON.stringify(selectedTags));
        else tagInput.show();
        jQuery('#history-description').val(jQuery('.ck-content').html());
    });
});