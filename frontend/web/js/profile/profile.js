jQuery(document).ready(function () {
    const changeInfo = jQuery('.change-info');
    const changePassword = jQuery('.change-password');
    let imgChoose = false;
    let imgClickEvent = 0;

    jQuery('#frontuser-image').on('fileselect', function (event) {
        jQuery('.file-preview-frame:first').css('display', 'none');
    });

    jQuery('.field-frontuser-image').on('click', function () {
        if (!imgChoose) {
            imgChoose = true;
            jQuery('.clickable').trigger('click');
        }

        imgClickEvent += 1;
        if (imgClickEvent === 3) {
            imgClickEvent = 0;
            imgChoose = false;
        }
    });

    jQuery('.change-info-click').on('click', function () {
        changeInfo.show();
        changePassword.hide();

        jQuery('.change-password-click').removeClass('active');
        jQuery('.change-info-click').addClass('active');
    });

    jQuery('.change-password-click').on('click', function () {
        changePassword.show();
        changeInfo.hide();

        jQuery('.change-info-click').removeClass('active');
        jQuery('.change-password-click').addClass('active');
    });
});