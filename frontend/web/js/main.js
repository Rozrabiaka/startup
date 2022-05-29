$(document).ready(function () {
    lazyLoad();
    const q = $('#q');
    const up = $('.up');
    const down = $('.down');
    const footerC = $('.footer-c');
    let hashtagsResult = true;
    let historyResult = true;

    $('.click-close-mmb').on('click', function () {
        $('.mobile-menu-block').hide();
    });

    $('.mobile-menu').on('click', function () {
        $('.mobile-menu-block').show();
    });

    //GLOBAL SEARCH
    q.autocomplete({
        appendTo: '#autocomplete-container-search',
        source: function (request, response) {
            hashtagsResult = true;
            historyResult = true;
            $('.search-loader').show();
            $.ajax({
                url: '/ajax/search',
                type: "GET",
                data: {"q": request.term},
                success: function (data) {
                    if (data) {
                        let autocomplete = {};
                        const qResult = $.parseJSON(data);
                        const hashtags = qResult.data.hashtags;
                        const history = qResult.data.history;

                        if (hashtags.length > 0) {
                            $.each(hashtags, function (arKey, arValue) {
                                autocomplete[arValue.id + '-hashtags'] = {
                                    'div': 'hashtags',
                                    'label': arValue.name,
                                    'id': arValue.id
                                }
                            });
                        }

                        if (history.length > 0) {
                            $.each(history, function (arKey, arValue) {
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

                    $('.search-loader').hide();
                }
            });
        },
        select: function (event, ui) {

        }, minLength: 3,
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        if (item.id === 'no-result-id' && item.div === 'no-result') {
            return $("<li></li>")
                .append("<div class='autocomplete-tag-name'>Результату не знайдено</div>")
                .appendTo(ul);
        }

        //TODO при навидени ошибка когда Хештеги и Пости в консоле
        if (hashtagsResult && item.div === 'hashtags') {
            $("<li></li>")
                .append("<div class='autocomplete-tag-name'>Хештеги: </div>")
                .appendTo(ul);
            hashtagsResult = false;
        }

        if (historyResult && item.div === 'history') {
            $("<li></li>")
                .append("<div class='autocomplete-tag-name tag-name-history'>Пости: </div>")
                .appendTo(ul);
            historyResult = false;
        }

        if (item.div === 'hashtags') {
            return $("<li></li>")
                .data("item.autocomplete", item)
                .append("<a href='/?tag=" + item.id + " '>" + item.label + "</a>")
                .appendTo(ul);
        }

        if (item.div === 'history') {
            return $("<li></li>")
                .data("item.autocomplete", item)
                .append("<a href='/?history=" + item.id + " '>" + item.label + "</a>")
                .appendTo(ul);
        }
    };
    //END GLOBAL SEARCH

    /* FOOTER SCROLL */
    $(".up").click(function () {
        down.show();
        footerC.show();
        up.hide();
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.down').offset().top
        }, 200);
    });

    $(".down").click(function () {
        down.hide();
        up.show();
        footerC.hide();
    });

    $(".links-dom").click(function () {
        $(this).find(".links-menu").toggle();
    });

    /* END FOOTER SCROLL */
});

function lazyLoad() {
    $('.story-image__content img').Lazy({
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        enableThrottle: true,
        visibleOnly: true,
        throttle: 300,
        effectTime: 500,
        threshold: 0,
        afterLoad: function (element) {
            element.parent().addClass('loaded-image');
            element.parent().removeClass('image');
        },
        onError: function (element) {
            console.log('error loading ' + element.data('src'));
        },
    });
}