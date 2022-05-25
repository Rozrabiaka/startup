jQuery(document).ready(function () {
    ClassicEditor.create(document.querySelector('#history-description'), {
        "toolbar": ["imageUpload", "bold", "link", "bulletedList", "uploadImage", "blockQuote"],
        "ckfinder": {
            "uploadUrl": "uploadImage.php",
            "options": {
                resourceType: ['jpeg', 'png', 'jpg']
            }
        },
    }).then(editor => {
        //TODO максимальное количество загружаемых файлов поставить
        //TODO загружать файлы поочередно
        //TODO удобство добавления картинки

        // editor.plugins.get('FileRepository').on('change:uploadTotal', evt => {
        //     console.log('Image uploaded evt');
        //     console.log(evt);
        // });
    }).catch(error => {
        console.error(error);
    });
});