jQuery(document).ready(function () {

    showCurrentSection();

    $("#payment_setting_test_mode").change(function(event) {
        if (event.currentTarget.checked) {
            jQuery('#payment_setting_token').val("a75b74cbcfe446509e8ee874f421bd67");
            jQuery('#payment_setting_service_id').val("5");
        } else {
            jQuery('#payment_setting_token').val("");
            jQuery('#payment_setting_service_id').val("");
        }
    });
    $("#payment_setting_type").change(showCurrentSection);

    function showCurrentSection() {
        let selected_value = jQuery('#payment_setting_type').val();

        let current_section = '';

        console.log(selected_value);
        if (selected_value == 'card')
        {
            jQuery('#successMessageContainer').hide(400);
        }
        else if (selected_value == 'erip')
        {
            jQuery('#erip_setting').show(400);
            jQuery('#successMessageContainer').show(400);
            current_section = 'erip_setting';
        }
        else if (selected_value == 'epos')
        {
            jQuery('#epos_setting').show(400);
            jQuery('#erip_setting').show(400);
            jQuery('#showQrCodeContainer').hide(400);
            jQuery('#successMessageContainer').hide(400);
            current_section = 'epos_setting';
        } else {
            jQuery('#successMessageContainer').hide(400);
        }

        jQuery('.other_setting').each(function () {

            if (current_section == 'epos_setting' && jQuery(this).attr('id') == 'erip_setting') {
                return;
            } else if (jQuery(this).attr('id') == current_section)
                return;
            jQuery(this).hide(400);
        });


    }
});

function paymentMethodOptions(method, id) {
    jQuery(function ($) {
        $.ajax({
            type: "GET",
            url: ajaxurl,
            data: {
                action: 'payment_options',
                method: method,
                id: id,
            },
            success: function (response) {
                location.reload();
            }
        });
    });
}