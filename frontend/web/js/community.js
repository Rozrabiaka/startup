$(document).ready(function () {
    let step = 1;
    const maxStep = 3;
    const form = jQuery('#create-community-form');

    showStepString();

    $('.community-b').click(function () {
        validation(step);
    });

    function validation(step) {
        if (step === 1) {
            const comInv = $('#community-name');
            const desInv = $('#community-description');
            const desLength = desInv.val().length;
            const comLength = comInv.val().length;

            if (comLength >= 3 && desLength >= 10 && desLength <= 150) {
                updateStep();
            }
        }

        if (step === 2) {
            const fileInput = $("#community-image");
            const files = fileInput.val();
            if (files.length > 0) {
                updateStep();
            }
        }

        if (step === 3) {
            const access = $('input[name="Community[community_access]"]:checked').val();
            const hisAdd = $('input[name="Community[community_his_add]"]:checked').val();

            if (typeof access !== 'undefined' && typeof hisAdd !== 'undefined')
                form.submit();
        }
    }

    function updateStep() {
        step = step + 1;
        const hideStep = step - 1;
        $('.community-step' + hideStep).hide();
        $('.community-step' + step).show();
        showStepString();
    }

    function showStepString() {
        $('.community-step-count').text(step + '/' + maxStep);
    }
});