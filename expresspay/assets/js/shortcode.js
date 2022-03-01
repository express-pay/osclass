jQuery(document).ready(function () {
	$("form#expresspay-method-form").submit(function(e) {
        jQuery('#expresspay-method-form').css('display', 'none');
        jQuery("#expresspay-results").html('').hide(0);
        jQuery("#expresspay-loading").show(350);

        jQuery(function ($) {
            $.ajax({
                type: "POST",
                url: $("form#expresspay-method-form").attr("action"),
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
});