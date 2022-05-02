jQuery(document).ready(function () {
    const changeInfo = jQuery('.change-info');
    const changePassword = jQuery('.change-password');

    jQuery('#frontuser-image').on('change', function (event) {
        const firstEl = jQuery('.file-preview-frame:first').remove();
        console.log(firstEl);
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