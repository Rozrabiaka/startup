jQuery(document).ready(function () {

    function readImage(input) {
        if (input.files && input.files[0]) {

            console.log(input.files);
            var reader = new FileReader();

            reader.readAsDataURL(input.files[0]);
        }
    }

    let file;
    jQuery('input[type=file]').change(function () {
        file = this.files;
    });


    jQuery('.upload-avatar').on('submit', (function (e) {
        console.log('here');

        // const formData = new FormData(this);
        // let file;
        // jQuery('input[type=file]').change(function () {
        //     console.log(this);
        //     file = this.files;
        // });

        // const data = new FormData();
        // jQuery.each(file, function (key, value) {
        //     data.append(key, value);
        // });
        //
        // console.log(data);

        jQuery.ajax({
            type: 'POST', // Тип запроса
            url: '/ajax/change-image',
            data: {'1':1}, // Данные которые мы передаем
            processData: false, // Отключаем, так как передаем файл
            success: function (data) {
                console.log(data)
            },
            error: function (data) {
                console.log(data);
            }
        });
    }));

    jQuery('.avatar').change(function () {
        // jQuery(".upload-avatar").submit();
        const data = new FormData();
        jQuery.each(file, function (key, value) {
            data.append(key, value);
        });

        console.log(data);
        jQuery.ajax({
            type: 'POST', // Тип запроса
            url: '/ajax/change-image',
            data: {'1':1}, // Данные которые мы передаем
            processData: false, // Отключаем, так как передаем файл
            success: function (data) {
                console.log(data)
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});