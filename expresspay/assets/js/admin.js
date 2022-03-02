jQuery(document).ready(function () {

    showCurrentSection();

    $("#payment_setting_test_mode").change(function(event) {
        if (event.currentTarget.checked) {
            jQuery('#payment_setting_token').val("a75b74cbcfe446509e8ee874f421bd67");
            jQuery('#payment_setting_service_id').val("5");
            jQuery('#payment_setting_secret_word').val("sandbox.expresspay.by");
        } else {
            jQuery('#payment_setting_token').val("");
            jQuery('#payment_setting_service_id').val("");
            jQuery('#payment_setting_secret_word').val("");
        }
    });
    $("#payment_setting_type").change(showCurrentSection);

    function showCurrentSection() {
        let selected_value = jQuery('#payment_setting_type').val();
        if (selected_value == 'epos')
        {
            jQuery('#erip_setting').show(400);
            jQuery('#erip_setting_path').hide(400);
            jQuery('#epos_setting').show(400);
        }
        else if (selected_value == 'erip')
        {
            jQuery('#erip_setting').show(400);
            jQuery('#erip_setting_path').show(400);
            jQuery('#epos_setting').hide(400);
        }
        else
        {
            jQuery('#erip_setting').hide(400);
            jQuery('#erip_setting_path').hide(400);
            jQuery('#epos_setting').hide(400);
        }
    }
});

function paymentMethodOptions(ajaxurl, method, id) {
    jQuery(function ($) {
        $.ajax({
            type: "GET",
            url: ajaxurl,
            data: {
                page:'ajax',
                action: 'runhook',
                hook: 'expresspay_optionEdit',
                method: method,
                id: id,
            },
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                console.error('expresspay_optionEdit error: ', error.responseJSON);
            }
        });
    });
}