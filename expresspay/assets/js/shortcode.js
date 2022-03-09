jQuery(document).ready(function () {
	$("form#expresspay-method-form").submit(function(e) {
        jQuery('#expresspay-method-form').hide(0);
        jQuery("#payment_message").html('').hide(0);
        jQuery("#expresspay-loading").show(350);

        jQuery(function ($) {
            $.ajax({
                type: "POST",
                url: $("form#expresspay-method-form").attr("action"),
                data: $("form#expresspay-method-form").serialize(),
                success: function (response) {
                    jQuery("#expresspay-loading").hide(0);
                    jQuery('#payment_message').html(response).show(0);
                    console.log(response);
                },
                error: function (error) {
                    jQuery("#expresspay-loading").hide(0);
                    jQuery('#expresspay-method-form').show(350);
                    jQuery("#payment_message").html('<p style="color:#D1001D;">'+error.responseText+'</p>').show(0);
                    console.error('expresspay_createInvoices error: ', error.responseText);
                }
            });
        });
        return false;
    });
});