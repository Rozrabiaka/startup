jQuery(document).ready(function () {
    const tagInput = jQuery('.input_hashtags input');
    const hashtags = jQuery('.hashtags');
    const form = jQuery('#create-history-form');
    const maxLength = 25;
    let selectedTags = [];
    let hashtagsCountValue = 0;

    if (hashtags.val().length > 0) {
        const validHashtags = hashtags.val();
        hashtags.val('');
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

    hashtags.on('keyup touchend', function () {
        if (jQuery(this).val().length >= maxLength) {
            hashtags.val(jQuery(this).val().substring(0, maxLength));
        }
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
            hashtags.attr('placeholder', 'Додати хештеги...');
        }
    });

    jQuery(document).mouseup(function (e) {
        const container = jQuery(".input_hashtags");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            if (hashtags.val().length > 0 && e.target.classList[0] !== 'ui-menu-item-wrapper') {
                resetHashtagsCountValue();
                setNewHashtag(hashtags.val());
                hashtags.val('');
            }
        }
    });

    hashtags.keypress(function (event) {
        const keycode = (event.keyCode ? event.keyCode : event.which);
        const charCode = String.fromCharCode(event.which);
        if (keycode === 13 || charCode === ',') {
            setNewHashtag(hashtags.val());
            hashtags.val('');
        }
    });

    async function setNewHashtag(label) {
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
            return 'g-' + Math.floor((1 + Math.random()) * 0x10000)
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

        selectedTags.push({
            'id': genId,
            'value': label
        });

        if (selectedTags.length > 0) hashtags.attr("placeholder", "");
        await getHashId(label, genId);
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

    async function getHashId(tag, genId) {
        await jQuery.ajax({
            url: '/ajax/search-hashtags',
            type: 'GET',
            data: {'hashtag': tag},
            success: function (data) {
                if (data) {
                    const newId = 'g-' + jQuery.parseJSON(data);
                    jQuery('#' + genId).attr("id", newId);
                    jQuery.each(selectedTags, function (index, value) {
                        if (value.id === genId) selectedTags[index].id = newId
                    });
                }
            }
        });
    }

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

    form.on('afterValidate', function (event, messages, errorAttributes) {
        tagInput.show();
        hashtags.val('');
        return false;
    });
});