<?php

class ExpressPayOptionsController extends AdminSecBaseModel 
{
    public $optionsModel;

    function __construct()
    {
        $this->optionsModel = ExpressPayOptionsModel::newInstance();
    }
    public function doOptionsList()
    {
        $listOptions = $this->optionsModel->listAll($page, $length);
        $totalOptions = count($this->optionsModel->listAll());

        // Exports it to make it available to the view.
        View::newInstance()->_exportVariableToView(
            "expresspay_options_list",
            $listOptions
        );
        View::newInstance()->_exportVariableToView(
            "expresspay_options_count",
            $totalOptions
        );
    }

    public function doOptions()
    {
        $id = osc_sanitize_int(Params::getParam("id"));

        if($id == 0){
            $param = array(
                'ApiUrl' => 'https://api.express-pay.by/v1/',
                'SandboxUrl' => 'https://sandbox-api.express-pay.by/v1/',
            );
        }
        else{
            $options = $this->optionsModel->findByPrimaryKey($id);
            $param = json_decode($options['options'], true);
        }
        
        // Экспорт данных для представления.
        View::newInstance()->_exportVariableToView(
            "expresspay_options",
            $param
        );
        View::newInstance()->_exportVariableToView(
            "expresspay_options_id",
            $options['id']
        );
    }

    public function doSaveOptions()
    {
        $id = osc_sanitize_int(Params::getParam("id"));

        $params = array(
            'Name' => osc_esc_js($_REQUEST['payment_setting_name']),
            'Type' => osc_esc_js($_REQUEST['payment_setting_type']),
            'Token' => osc_esc_js($_REQUEST['payment_setting_token']),
            'ServiceId' => osc_esc_js($_REQUEST['payment_setting_service_id']),
            'SecretWord' => osc_esc_js($_REQUEST['payment_setting_secret_word']),
            'SecretWordForNotification' => osc_esc_js($_REQUEST['payment_setting_secret_word_for_notification']),
            'ApiUrl' => osc_esc_js($_REQUEST['payment_setting_api_url']),
            'SandboxUrl' => osc_esc_js($_REQUEST['payment_setting_sandbox_url']),
            'EripPath' => osc_esc_js($_REQUEST['payment_setting_erip_path']),
        );

        
        if (isset($_REQUEST['payment_setting_test_mode']))
            $params['TestMode'] = osc_esc_js($_REQUEST['payment_setting_test_mode']) ? 1 : 0;

        if (isset($_REQUEST['payment_setting_use_signature_for_notification']))
            $params['UseSignatureForNotification'] = osc_esc_js($_REQUEST['payment_setting_use_signature_for_notification']) ? 1 : 0;

        switch ($params['Type']) {
            case 'erip':
                if (isset($_REQUEST['payment_setting_show_qr_code']))
                    $params['ShowQrCode'] = osc_esc_js($_REQUEST['payment_setting_show_qr_code']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_name']))
                    $params['CanChangeName'] = osc_esc_js($_REQUEST['payment_setting_can_change_name']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_address']))
                    $params['CanChangeAddress'] = osc_esc_js($_REQUEST['payment_setting_can_change_address']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_amount']))
                    $params['CanChangeAmount'] = osc_esc_js($_REQUEST['payment_setting_can_change_amount']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_send_email_notification']))
                    $params['SendEmail'] = osc_esc_js($_REQUEST['payment_setting_send_email_notification']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_send_sms_notification']))
                    $params['SendSms'] = osc_esc_js($_REQUEST['payment_setting_send_sms_notification']) ? 1 : 0;

                break;
            case 'card':
                break;
            case 'epos':
                if (isset($_REQUEST['payment_setting_show_qr_code']))
                    $params['ShowQrCode'] = osc_esc_js($_REQUEST['payment_setting_show_qr_code']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_name']))
                    $params['CanChangeName'] = osc_esc_js($_REQUEST['payment_setting_can_change_name']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_address']))
                    $params['CanChangeAddress'] = osc_esc_js($_REQUEST['payment_setting_can_change_address']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_can_change_amount']))
                    $params['CanChangeAmount'] = osc_esc_js($_REQUEST['payment_setting_can_change_amount']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_send_email_notification']))
                    $params['SendEmail'] = osc_esc_js($_REQUEST['payment_setting_send_email_notification']) ? 1 : 0;

                if (isset($_REQUEST['payment_setting_send_sms_notification']))
                    $params['SendSms'] = osc_esc_js($_REQUEST['payment_setting_send_sms_notification']) ? 1 : 0;

                $params['ServiceProviderCode'] = osc_esc_js($_REQUEST['payment_setting_service_provider_code']);
                $params['ServiceEposCode'] = osc_esc_js($_REQUEST['payment_setting_service_epos_code']);
                break;
        }
        
        $options = array('name' => $params['Name'], 'type' => $params['Type'], 'options' => json_encode($params), 'isactive' => 1);
        
        if($id == 0){
            $this->optionsModel->insert($options);
        }
        else {
            $this->optionsModel->updateByPrimaryKey($options, $id);
        }

        $this->redirectTo(osc_route_admin_url('expresspay-admin-options-list'));
    }
    
    public function optionEdit(){
        $method = osc_esc_js(Params::getParam("method"));
        $id = osc_sanitize_int(Params::getParam("id"));

        if($id != 0){
            $optionsModel = ExpressPayOptionsModel::newInstance();
            if($method == 'payment_off'){
                $optionsModel->updateByPrimaryKey(array('isactive'=>0), $id);
            }
            else if($method == 'payment_on'){
                $optionsModel->updateByPrimaryKey(array('isactive'=>1), $id);
            }
            else if($method == 'payment_delete'){
                $optionsModel->deleteByPrimaryKey($id);
            }
        }
    }
}