<?php include __DIR__ . '\admin_header.php';?>

<a class="button-right button-small" href="#" onclick="window.history.back()">
    <?php _e('Back', 'expresspay') ?>
</a>

<?php $param = expresspay_get_options();?>
<input type="hidden" id="ajax-url" value="<?php echo osc_esc_html($ajax_url); ?>" />
<form class="payment_setting_save_page" id="payment_setting_save_page" method="post" action="<?php echo osc_esc_html(osc_route_admin_url('expresspay-admin-options-save', array('id' => expresspay_get_options_id()))); ?>">
    <div class="input-field">
        <label for="payment_setting_name">
            <?php _e('Payment method name', 'expresspay') ?>
        </label>
        <input type="text" id="payment_setting_name" name="payment_setting_name" required placeholder="<?php _e('Enter the name of the payment method', 'expresspay') ?>" value="<?php echo osc_esc_html(isset($param['Name']) ? $param['Name'] : ''); ?>" />
    </div>

    <div class="input-field">
        <label for="payment_setting_type">
            <?php _e('Payment method type', 'expresspay') ?>
        </label>
        <select id="payment_setting_type" name="payment_setting_type" required>
            <option disabled value="" selected hidden><?php _e('Select the type of payment method', 'expresspay') ?></option>
            <option value="erip" <?php echo osc_esc_html(isset($param['Type']) && $param['Type'] == 'erip' ? 'selected' : ''); ?>><?php _e('ERIP', 'expresspay') ?></option>
            <option value="epos" <?php echo osc_esc_html(isset($param['Type']) && $param['Type'] == 'epos' ? 'selected' : ''); ?>><?php _e('E-POS', 'expresspay') ?></option>
            <option value="card" <?php echo osc_esc_html(isset($param['Type']) && $param['Type'] == 'card' ? 'selected' : ''); ?>><?php _e('Internet-acquiring', 'expresspay') ?></option>
        </select>
    </div>

    <div class="input-field">
        <label for="payment_setting_test_mode">
            <?php _e('Test mode', 'expresspay') ?>
        </label>
        <input type="checkbox" id="payment_setting_test_mode" name="payment_setting_test_mode" <?php echo osc_esc_html(isset($param['TestMode']) && $param['TestMode'] == 1 ? 'checked' : '') ?> />
    </div>

    <hr/>

    <div class="input-field">
        <label for="payment_setting_token">
            <?php _e('API key', 'expresspay') ?>
        </label>
        <input type="text" id="payment_setting_token" name="payment_setting_token" required placeholder="<?php _e('Enter API key', 'expresspay') ?>" value="<?php echo osc_esc_html(isset($param['Token']) ? $param['Token'] : ''); ?>" />
    </div>

    <div class="input-field">
        <label for="payment_setting_service_id">
            <?php _e('Service number', 'expresspay') ?>
        </label>
        <input type="text" id="payment_setting_service_id" name="payment_setting_service_id" required placeholder="<?php _e('Enter service number', 'expresspay') ?>" value="<?php echo osc_esc_html(isset($param['ServiceId']) ? $param['ServiceId'] : ''); ?>" />
    </div>

    <div class="input-field">
        <label for="payment_setting_notification_url">
            <?php _e('Address for notifications', 'expresspay') ?>
        </label>
        <input type="text" id="payment_setting_notification_url" value="<?php echo osc_esc_html(expresspay_url_notifications()); ?>" readonly />
    </div>
    <div class="input-field">
        <label for="payment_setting_secret_word">
            <?php _e('Secret word', 'expresspay') ?>
        </label>
        <input type="text" id="payment_setting_secret_word" name="payment_setting_secret_word" placeholder="<?php _e('Enter secret word', 'expresspay') ?>" value="<?php echo osc_esc_html(isset($param['SecretWord']) ? $param['SecretWord'] : ''); ?>" />
    </div>

    <div class="input-field">
        <label for="payment_setting_use_signature_for_notification">
            <?php _e('Enable digital signature for notifications', 'expresspay') ?>
        </label>
        <input type="checkbox" id="payment_setting_use_signature_for_notification" name="payment_setting_use_signature_for_notification" <?php echo osc_esc_html(isset($param['UseSignatureForNotification']) && $param['UseSignatureForNotification'] == 1 ? 'checked' : '') ?> />
    </div>

    <div class="input-field">
        <label for="payment_setting_secret_word_for_notification">
            <?php _e('Secret word for notifications', 'expresspay') ?>
        </label>
        <input type="text" id="payment_setting_secret_word_for_notification" name="payment_setting_secret_word_for_notification" placeholder="<?php _e('Enter secret word for notifications', 'expresspay') ?>" value="<?php echo osc_esc_html(isset($param['SecretWordForNotification']) ? $param['SecretWordForNotification'] : ''); ?>" />
    </div>
    <hr />

    <div id="erip_setting">
        <div class="input-field" id="showQrCodeContainer">
            <label for="payment_setting_show_qr_code">
                <?php _e('Show QR code', 'expresspay') ?>
            </label>
            <input type="checkbox" id="payment_setting_show_qr_code" value="1" name="payment_setting_show_qr_code" <?php echo osc_esc_html(isset($param['ShowQrCode']) && $param['ShowQrCode'] == 1 ? 'checked' : '') ?> />
        </div>
        <div class="input-field">
            <label for="payment_setting_can_change_name">
                <?php _e('Allowed to change name', 'expresspay') ?>
            </label>
            <input type="checkbox" id="payment_setting_can_change_name" name="payment_setting_can_change_name" <?php echo osc_esc_html(isset($param['CanChangeName']) && $param['CanChangeName'] == 1 ? 'checked' : '') ?> />
        </div>
        <div class="input-field">
            <label for="payment_setting_can_change_address">
                <?php _e('Allowed to change address', 'expresspay') ?>
            </label>
            <input type="checkbox" id="payment_setting_can_change_address" name="payment_setting_can_change_address" <?php echo osc_esc_html(isset($param['CanChangeAddress']) && $param['CanChangeAddress'] == 1 ? 'checked' : '') ?> />
        </div>
        <div class="input-field">
            <label for="payment_setting_can_change_amount">
                <?php _e('Allowed to change amount', 'expresspay') ?>
            </label>
            <input type="checkbox" id="payment_setting_can_change_amount" name="payment_setting_can_change_amount" <?php echo osc_esc_html(isset($param['CanChangeAmount']) && $param['CanChangeAmount'] == 1 ? 'checked' : '') ?> />
        </div>
        <div class="input-field">
            <label for="payment_setting_send_email_notification">
                <?php _e('Send email notification to client', 'expresspay') ?>
            </label>
            <input type="checkbox" id="payment_setting_send_email_notification" name="payment_setting_send_email_notification" <?php echo osc_esc_html(isset($param['SendEmail']) && $param['SendEmail'] == 1 ? 'checked' : '') ?> />
        </div>
        <div class="input-field">
            <label for="payment_setting_send_sms_notification">
                <?php _e('Send sms notification to the client', 'expresspay') ?>
            </label>
            <input type="checkbox" id="payment_setting_send_sms_notification" name="payment_setting_send_sms_notification" <?php echo osc_esc_html(isset($param['SendSms']) && $param['SendSms'] == 1 ? 'checked' : '') ?> />
        </div>
        <hr />
    </div>

    <div id="erip_setting_path">
        <div class="input-field">
            <label for="payment_setting_erip_path">
                <?php _e('Path along the ERIP branch', 'expresspay') ?>
            </label>
            <input type="text" id="payment_setting_erip_path" name="payment_setting_erip_path" placeholder="<?php _e('Enter Path along the ERIP branch', 'expresspay') ?>" value="<?php echo osc_esc_html(isset($param['EripPath']) ? $param['EripPath'] : ''); ?>" />
        </div>
        <hr />
    </div>
    <div id="epos_setting">
        <div class="input-field">
            <label for="payment_setting_service_provider_code">
                <?php _e('Service provider code', 'expresspay') ?>
            </label>
            <input type="text" id="payment_setting_service_provider_code" name="payment_setting_service_provider_code" placeholder="<?php _e('Enter service provider code', 'wordpress_expresspay') ?>" value="<?php echo osc_esc_html(isset($param['ServiceProviderCode']) ? $param['ServiceProviderCode'] : ''); ?>" />
        </div>
        <div class="input-field">
            <label for="payment_setting_service_epos_code">
                <?php _e('E-POS service code', 'expresspay') ?>
            </label>
            <input type="text" id="payment_setting_service_epos_code" name="payment_setting_service_epos_code" placeholder="<?php _e('Enter E-POS service code', 'wordpress_expresspay') ?>" value="<?php echo osc_esc_html(isset($param['ServiceEposCode']) ? $param['ServiceEposCode'] : ''); ?>" />
        </div>
        <hr />
    </div>

    <div class="input-field">
        <label for="payment_setting_api_url">
            <?php _e('API address', 'expresspay') ?>
        </label>
        <input type="text" id="payment_setting_api_url" name="payment_setting_api_url" required placeholder="<?php _e('Enter API address', 'expresspay') ?>" value="<?php echo osc_esc_html(isset($param['ApiUrl']) ? $param['ApiUrl'] : ''); ?>" />
    </div>

    <div class="input-field">
        <label for="payment_setting_sandbox_url">
            <?php _e('Test API address', 'expresspay') ?>
        </label>
        <input type="text" id="payment_setting_sandbox_url" name="payment_setting_sandbox_url" required placeholder="<?php _e('Enter test API address', 'expresspay') ?>" value="<?php echo osc_esc_html(isset($param['SandboxUrl']) ? $param['SandboxUrl'] : ''); ?>" />
    </div>
    <div class="button-field">
        <input class="button-left button-action" type="submit" value="<?php _e('Save', 'expresspay') ?>">
        <input class="button-right button-action" type="button" onclick="window.location.href='<?php echo osc_esc_html('?page=plugins&action=renderplugin&route=expresspay-admin-options-list'); ?>'" value="<?php _e('Cancel', 'expresspay') ?>">
    </div>
</form>
<?php include __DIR__  . '\admin_footer.php';?>