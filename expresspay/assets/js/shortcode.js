var base_url;
jQuery(document).ready(function () {
    let expressPayAccountNumber = GetParameterValues('ExpressPayAccountNumber');
    let type_id = GetParameterValues('type_id');
    let expressPayInvoiceNo = GetParameterValues('ExpressPayInvoiceNo');
    let signature = GetParameterValues('Signature');
    let result = GetParameterValues('result');

    if (result == true) {
        checkInvoice(signature, expressPayAccountNumber, expressPayInvoiceNo, type_id);
    } else if (result == false) {
        checkInvoice(signature, expressPayAccountNumber, expressPayInvoiceNo, type_id);
    }

    jQuery('#btn_step_first').click(function () {

        let type = jQuery('#first_step input[name=payment_method]:checked').attr('data-type');
        let sum = jQuery('#expresspay-payment-sum').val();

        if (type == undefined || isNaN(sum) || sum < 0.01) {
            return;
        } else if (type == "card") {
            jQuery('#fio-section').hide();
            jQuery('#first_step').hide(350);
            jQuery('#second_step').show(350);

        } else {
            getPaymentSetting();
            jQuery('#first_step').hide(350);
            jQuery('#second_step').show(350);
        }


    });

    jQuery('#back_second_step').click(function () {

        jQuery('#first_step').show(350);
        jQuery('#second_step').hide(350);

    });

    jQuery('#btn_second_step').click(function () {

        setTableValue();
        getFormData();
        jQuery('#second_step').hide(350);
        jQuery('#three_step').show(350);

    });

    jQuery('#back_three_step').click(function () {


        let type = jQuery('input[name=payment_method]:checked').attr('data-type');

        if (type == "card") {
            jQuery('#first_step').show(350);
            jQuery('#three_step').hide(350);
        } else {
            jQuery('#second_step').show(350);
            jQuery('#three_step').hide(350);

        }

    });

    jQuery('#replay_btn').click(function () {
        let url = window.location.href;

        let expressPayAccountNumber = GetParameterValues('ExpressPayAccountNumber');
        let expressPayInvoiceNo = GetParameterValues('ExpressPayInvoiceNo');
        let signature = GetParameterValues('Signature');
        let type_id = GetParameterValues('type_id');

        url = url.substring(0, url.indexOf('type_id') - 1);

        window.location.href = url;
    });

    function setTableValue() {
    
        let type = jQuery("input[type='radio']:checked:last").next().text();

        jQuery('#three_step .table .row.type .val').html(type);

        let amount = jQuery('#expresspay-payment-sum').val();

        jQuery('#three_step .table .row.amount .val').html(amount + " BYN");
    }


    $("form#expresspay-method-form").submit(function(e) {
        jQuery('#expresspay-method-form').css('display', 'none');
        jQuery("#expresspay-results").html('').hide(0);
        jQuery("#expresspay-loading").show(350);

        jQuery(function ($) {
            $.ajax({
                type: "GET",
                url: base_url,
                data: $("form#expresspay-method-form").serialize(),
                success: function (response) {
                    jQuery("#expresspay-loading").hide(0);
                    jQuery('#payment_message').css('display', 'block');
                    jQuery('#payment_message').html(response);
                    console.log(response);
                },
                error: function (error) {
                    jQuery("#expresspay-loading").hide(0);
                    jQuery('#expresspay-method-form').css('display', 'block');
                    jQuery("#expresspay-results").html(error.responseJSON).show(350);
                    console.log('expresspay_createInvoices error: ', error.responseJSON);
                }
            });
        });
        return false;
    });


    function GetParameterValues(param) {
        var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < url.length; i++) {
            var urlparam = url[i].split('=');
            if (urlparam[0] == param) {
                return urlparam[1];
            }
        }
    }

    function checkInvoice(signature, account_no, invoice_no, type_id) {
        let url = jQuery('#ajax-url').val();

        jQuery('#first_step').hide(800);
        jQuery('#second_step').hide(800);
        jQuery('#three_step').hide(800);
        jQuery('#response_step').show(350);
        jQuery('#replay_btn').hide(800);

        jQuery(function ($) {
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    action: 'check_invoice',
                    type_id: type_id,
                    signature: signature,
                    account_no: account_no,
                    invoice_no: invoice_no
                },
                success: function (data) {
                    data = $.parseJSON(data);

                    if (data.status == "success") {
                        jQuery('#service_response_message').hide(800);
                        jQuery('#response_message').addClass('success');
                        jQuery('#replay_btn').show(800);
                        jQuery('#replay_btn').html('Продолжить');

                    } else {
                        jQuery('#service_response_message').hide(800);
                        jQuery('#response_message').addClass('fail');
                        jQuery('#replay_btn').show(800);
                        jQuery('#replay_btn').html('Повторить');
                    }
                    jQuery('#response_message').html(data.message);
                }

            });
        });
    }

    function getPaymentSetting() {
        let type_id = jQuery('#first_step input[name=payment_method]:checked').val();

        let type = jQuery('#first_step input[name=payment_method]:checked').attr('data-type');

        if (type == 'card')
            return;

        let url = jQuery('#ajax-url').val();

        jQuery(function ($) {
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    action: 'get_payment_setting',
                    type_id: type_id,
                },
                success: function (response) {

                    response = $.parseJSON(response);

                    setSecondStepFields(response);

                }
            });
        });
    }

    function setSecondStepFields(data) {

        if (data.SendEmail == 1) {
            jQuery('#expresspay-payment-email-container').show(400);
        } 

        if (data.SendSms == 1) {
            jQuery('#expresspay-payment-phone-container').show(400);
        }

    }
});