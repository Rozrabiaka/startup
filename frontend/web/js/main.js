jQuery(document).ready(function () {
    lazyLoad();
    const q = jQuery('#q');
    const up = jQuery('.up');
    const down = jQuery('.down');
    const footerC = jQuery('.footer-c');
    let hashtagsResult = true;
    let historyResult = true;

    jQuery('.click-close-mmb').on('click', function () {
        jQuery('.mobile-menu-block').hide();
    });

    jQuery('.mobile-menu').on('click', function () {
        jQuery('.mobile-menu-block').show();
    });

    q.autocomplete({
        appendTo: '#autocomplete-container-search',
        source: function (request, response) {
            hashtagsResult = true;
            historyResult = true;
            jQuery('.search-loader').show();
            jQuery.ajax({
                url: '/ajax/search',
                type: "GET",
                data: {"q": request.term},
                success: function (data) {
                    if (data) {
                        let autocomplete = {};
                        const qResult = jQuery.parseJSON(data);
                        const hashtags = qResult.data.hashtags;
                        const history = qResult.data.history;

                        if (hashtags.length > 0) {
                            jQuery.each(hashtags, function (arKey, arValue) {
                                autocomplete[arValue.id + '-hashtags'] = {
                                    'div': 'hashtags',
                                    'label': arValue.name,
                                    'id': arValue.id
                                }
                            });
                        }

                        if (history.length > 0) {
                            jQuery.each(history, function (arKey, arValue) {
                                autocomplete[arValue.id + '-history'] = {
                                    'div': 'history',
                                    'label': arValue.title,
                                    'id': arValue.id
                                }
                            });
                        }

                        if (history.length === 0 && hashtags.length === 0) {
                            autocomplete['id-none'] = {
                                'div': 'no-result',
                                'label': '',
                                'value': '',
                                'id': 'no-result-id'
                            }
                        }

                        response(autocomplete);
                    }

                    jQuery('.search-loader').hide();
                }
            });
        },
        select: function (event, ui) {

        }, minLength: 3,
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        if (item.id === 'no-result-id' && item.div === 'no-result') {
            return jQuery("<li></li>")
                .append("<div class='autocomplete-tag-name'>Результату не знайдено</div>")
                .appendTo(ul);
        }

        //TODO при навидени ошибка когда Хештеги и Пости в консоле
        if (hashtagsResult && item.div === 'hashtags') {
            jQuery("<li></li>")
                .append("<div class='autocomplete-tag-name'>Хештеги: </div>")
                .appendTo(ul);
            hashtagsResult = false;
        }

        if (historyResult && item.div === 'history') {
            jQuery("<li></li>")
                .append("<div class='autocomplete-tag-name tag-name-history'>Пости: </div>")
                .appendTo(ul);
            historyResult = false;
        }

        if (item.div === 'hashtags') {
            return jQuery("<li></li>")
                .data("item.autocomplete", item)
                .append("<a href='/?tag=" + item.id + " '>" + item.label + "</a>")
                .appendTo(ul);
        }

        if (item.div === 'history') {
            return jQuery("<li></li>")
                .data("item.autocomplete", item)
                .append("<a href='/?history=" + item.id + " '>" + item.label + "</a>")
                .appendTo(ul);
        }
    };

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

function lazyLoad() {
    jQuery('.image img').Lazy({
        beforeLoad: function (element) {
            element[0].style.opacity = 1;
        },
        afterLoad: function (element) {
            element.parent().addClass('loaded-image');
            element.parent().removeClass('image');
        },
        // your configuration goes here
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        visibleOnly: true,
        onError: function (element) {
            console.log('error loading ' + element.data('src'));
        }
    });
}