jQuery(document).ready(function () {
    const changeInfo = jQuery('.change-info');
    const changePassword = jQuery('.change-password');
    const communityScroll = jQuery('.community-scroll');
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

    $('.change-click-event').on('click', function () {
        eventActive(this.className.split(' ')[0]);
    });

    function eventActive(className) {
        $('.change-click').find('.active').removeClass('active');
        $('.' + className).addClass('active');

        switch (className) {
            case 'change-info-click':
                changeInfo.show();
                changePassword.hide();
                communityScroll.hide();
                break;
            case 'change-password-click':
                changePassword.show();
                changeInfo.hide();
                communityScroll.hide();
                break;
            case 'community-setting-click':
                communityScroll.show();
                changePassword.hide();
                changeInfo.hide();
                break;
        }
    }
});