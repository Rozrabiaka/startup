jQuery(document).ready(function () {
    let id = 1;
    const text = jQuery('.text-q');
    const author = jQuery('.author-q');

    setInterval(function () {
        jQuery.ajax({
            type: "GET",
            url: "/ajax/quote",
            data: {'id': id},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (result) {
                if (result.success) {
                    id += 1;
                    text.text(result.data.text);
                    author.text(result.data.author);
                } else id = 1;
            },
            error: function (errormessage) {
                console.log('error');
            }
        });
    }, 8000);
});