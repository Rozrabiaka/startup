jQuery(document).ready(function () {
    ClassicEditor.create(document.querySelector('#history-description'), {
        "toolbar": ["bold", "link", "bulletedList", "uploadImage", "blockQuote"],
        "ckfinder": {
            "uploadUrl": "/uploadImage.php",
            "options": {
                resourceType: ['jpeg', 'png', 'jpg']
            }
        },
    }).then( editor => {
        window.editor = editor;
    } ).catch(error => {
        console.error(error);
    });
});