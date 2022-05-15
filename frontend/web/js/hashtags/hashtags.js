jQuery(document).ready(function () {
    const tagInput = jQuery('.input_hashtags input');
    const hashtags = jQuery('.hashtags');
    const form = jQuery('#create-history-form');
    const maxLength = 25;
    let selectedTags = [];
    let hashtagsCountValue = 0;

    if (hashtags.val().length > 0) {
        const validHashtags = hashtags.val();
        hashtags.val("");
        if (isValidJSONString(validHashtags)) {
            const json = JSON.parse(validHashtags);
            if (json.length > 0) {
                jQuery.each(json, function (index, value) {
                    setNewHashtag(value.value);
                });
            }
        }
    }

    jQuery('.field-history-hashtags').on('click', function () {
        hashtags.focus();
    });

    hashtags.on("input", function () {
        if (jQuery(this).val().length >= maxLength) {
            hashtags.val(jQuery(this).val().substring(0, maxLength));
        }

        const width = hashtags.width();
        if (jQuery(this).val().length > hashtagsCountValue) {
            hashtagsCountValue = jQuery(this).val().length;
            hashtags.css('width', (width + 12) + 'px');
        } else if (jQuery(this).val().length < hashtagsCountValue) {
            hashtagsCountValue = jQuery(this).val().length;
            if (width > 30) hashtags.css('width', (width - 12) + 'px');
            else hashtags.css('width', '34px');
        } else if (jQuery(this).val().length === 0) {
            hashtagsCountValue = 0;
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

        selectedTags = selectedTags.filter(function (elem) {
            return elem.id !== id;
        });

        if (selectedTags.length < 9) {
            hashtags.prop('disabled', false);
            hashtags.show();
        }

        if (selectedTags.length === 0) {
            hashtags.attr("placeholder", "Додати хештеги...");
            hashtags.css('width', '100%');
        }
    });

    jQuery(document).mouseup(function (e) {
        const container = jQuery(".input_hashtags");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            if (hashtags.val().length > 0) {
                resetHashtagsCountValue();
                setNewHashtag(hashtags.val());
                hashtags.val("");
            }
        }
    });

    hashtags.keypress(function (event) {
        const keycode = (event.keyCode ? event.keyCode : event.which);
        const charCode = String.fromCharCode(event.which);
        if (keycode === 13 || charCode === ',') {
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

        if (selectedTags.length > 0) hashtags.attr("placeholder", "");
    }

    form.on('keyup keypress', function (e) {
        const keyCode = e.keyCode || e.which;
        const charCode = String.fromCharCode(e.which);
        if (keyCode === 13 || charCode === ',') {
            resetHashtagsCountValue();
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

    function resetHashtagsCountValue() {
        hashtagsCountValue = 0;
    }

    function isValidJSONString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
});