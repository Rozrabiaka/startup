jQuery(document).ready(function () {
    if (jQuery(".index-top")[0]) jQuery('.history-content').css('margin-top', '150px');
    else jQuery('.history-content').css('margin-top', '0');

    jQuery(document).on('click', '.watch-more', function (e) {
        const el = this.id;
        const id = el.replace('show-', '');
        const close = jQuery('[data-key=' + id + ']').find('.close-story');
        const idEl = jQuery('#' + el);

        const block = jQuery('[data-key=' + id + '] .story-block');
        if (close.length > 0) {
            block.css('max-height', '450px');
            idEl.text('Читати повністю');
            idEl.removeClass('close-story');

            jQuery([document.documentElement, document.body]).animate({
                scrollTop: block.offset().top
            }, 200);
        } else {
            block.css('max-height', '100%');
            idEl.text('Закрити');
            idEl.addClass('close-story')
        }
    });
});