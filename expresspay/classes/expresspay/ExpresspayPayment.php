<?php
class ExpresspayPayment {
    public function __construct() { 
    }
  
    public static function button($amount = '0.00', $description = '', $itemnumber = '', $extra_array = null) {
        $extra_array = osp_prepare_custom($extra_array);
        echo '<li class="payment express-btn"><a class="osp-has-tooltip" title="' . osc_esc_html(__('A form will open to select the payment method via express-pay.by', 'expresspay')) . 
        '" href="#" onclick="expresspay_pay(\''.$amount.'\',\''.osc_esc_js($description).'\',\''.$itemnumber.'\',\''.$extra_array.'\'); return false;">
        <img src="' . expresspay_assets_url('img/logo.png') . '" ></a></li>';
    }
    
    public static function dialogJS() { 
        $listPaymentMethod = ExpressPayOptionsModel::newInstance()->listAll();?>

        <div id="expresspay-overlay" class="osp-custom-overlay"></div>
        <div id="expresspay-dialog" class="osp-custom-dialog" style="display:none;">
            <div class="osp-inside">
                <div class="osp-top">
                    <span>Express-pay.by</span>
                    <div class="osp-close"><i class="fa fa-times"></i></div>
                </div>

                <div class="osp-body">
                    <div id="expresspay-info">
                        <div id="expresspay-data">
                            <p id="expresspay-desc"></p>
                            <label><?php _e('Payment amount', 'osclass_pay'); ?></label>
                            <p id="expresspay-price"></p>
                        </div>
                    </div>
                    <div id="expresspay-loading">
                        <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
                        <span><?php echo osc_esc_js(__('Whait second...', 'expresspay'));?></span>
                    </div>
                    <form id="expresspay-method-form" method="POST" class="nocsrf" action="<?php echo osc_base_url(true); ?>" >
                        <input type="hidden" name="page" value="ajax" />
                        <input type="hidden" name="action" value="runhook" />
                        <input type="hidden" name="hook" value="expresspay_createInvoices" />

                        <input type="hidden" name="amount" id="expresspay-amount" value="" />
                        <input type="hidden" name="description" id="expresspay-description" value=""/>
                        <input type="hidden" name="itemnumber" id="expresspay-itemnumber" value="" />
                        <input type="hidden" name="extra" id="expresspay-extra" value=""/>
                        <label><?php _e('Select a payment method', 'expresspay') ?></label>

                        <?php foreach ($listPaymentMethod as $row) : ?>
                            <?php if ($row['isactive'] == 1) : ?>
                                <div class="row">
                                    <input type="radio" name="paymentmethodid" value="<?php echo osc_esc_html($row['id']); ?>"/>
                                    <?php echo osc_esc_html($row['name']); ?>
                                </div>
                            <?php endif ?>
                        <?php endforeach; ?>
                        <input type="submit" id="expresspay-method-submit-btn" value="<?php _e('Select', 'expresspay') ?>" />
                    </form>
                    <div id="payment_message"></div>
                </div>
                <div id="expresspay-results">
                    <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
                    <span><?php echo osc_esc_js(__('Processing the payment, please wait...', 'osclass_pay'));?></span>
                </div>
                <div id="expresspay-response"></div>
            </div>
        </div>
        <link rel="stylesheet" href="<?php echo expresspay_assets_url('css/font-awesome.min.css');?>">
        <script type="text/javascript" src="<?php echo expresspay_assets_url('js/shortcode.js?v='.osp_param('version'));?>"></script>
        <script type="text/javascript">
            $('#expresspay-dialog .osp-close, #expresspay-overlay').on('click', function(e){ 
                e.stopPropagation();
                $('.osp-custom-dialog').fadeOut(200);
                $('.osp-custom-overlay').fadeOut(200);
            });
            function expresspay_pay(amount, description, itemnumber, extra) {
                $("#expresspay-desc").html(description);
                $("#expresspay-price").html(amount+" <?php echo osp_currency(); ?>");

                $('#expresspay-amount').val(amount);
                $('#expresspay-description').val(description);
                $('#expresspay-itemnumber').val(itemnumber);
                $('#expresspay-extra').val(extra);

                $("#expresspay-loading").hide(0);
                $("#expresspay-info").show();
                
                $('#expresspay-dialog').fadeIn(200).fadeIn(200);
                $('#expresspay-overlay').fadeIn(200);
                $("#expresspay-results").html('').hide(0);
            }
        </script>
      <?php
    }

    /**
     * Получение информациооного сообщения для способа оплаты ЕРИП
     * 
     * @param object $options    Настройки интеграции
     * @param string $account_no Номер счета присвоенный интеграцией
     * 
     * @return string $hash Сформированное сообщение
     */
    static function getEripMessage($options, $account_no)
    {
        $message_success_erip = __("<h3>Account added to the ERIP system for payment</h3><h4>Your order number: ##order_id##</h4>".
        "You need to make a payment in any system that allows you to pay through ERIP (items banking services, ATMs, payment terminals, Internet banking systems, client banking, etc.).".
        "<br/> 1. To do this, in the list of ERIP services go to the section:<br/><b>##erip_path##</b>".
        "<br/> 2. Next, enter the order number <b>##order_id##</b> and click \"Continue\"".
        "<br/> 3. Check if the information is correct".
        "<br/> 4. Make a payment", "expresspay");

        $message_success_erip = str_replace("##order_id##", $account_no, $message_success_erip);
        $message_success_erip = str_replace("##erip_path##", $options->EripPath, $message_success_erip);

        return $message_success_erip;
    }
    
    /**
     * Получение информациооного сообщения для способа оплаты E-POS
     * 
     * @param object $options    Настройки интеграции
     * @param string $account_no Номер счета присвоенный интеграцией
     * 
     * @return string $hash Сформированное сообщение
     */
    static function getEposMessage($options, $account_no)
    {
        $epos_code = $options->ServiceEposCode.'-'.$options->ServiceProviderCode.'-'.$account_no;
        $message_success_epos = __("<h3>Account added to the E-POS system for payment</h3><h4>Your order number: ##epos_code##</h4>".
        "You need to make a payment in any system that allows you to pay through ERIP (banking service points, ATMs, payment terminals, Internet banking systems, client banking, etc.).".
        "<br/> 1. To do this, in the list of ERIP services, go to the section: <b> Settlement System (ERIP)-&gt; E-POS Service-&gt; E-POS - payment for goods and services</b>".
        "<br/> 2. In the Code field, enter <b>##epos_code##</b> and click \"Continue\"".
        "<br/> 3. Check the correctness of the information".
        "<br/> 4. Make a payment", "expresspay");
        $message_success_epos = str_replace("##epos_code##", $epos_code, $message_success_epos);

        return $message_success_epos;
    }

    /**
     * Получение информациооного сообщения для способа оплаты E-POS
     * 
     * @param object $options    Настройки интеграции
     * @param string $account_no Номер счета присвоенный интеграцией
     * @param string $form_url   Ссылка на форму оплаты
     * 
     * @return string $hash Сформированное сообщение
     */
    static function getCardMessage($options, $account_no, $form_url)
    {
        $message_success_card = __("<h3>Account added to system</h3><h4>Your order number: ##order_id##</h4>".
		"<a href=\"##form_url##\">Go to payment</a>", 'expresspay');

        $message_success_card = str_replace("##order_id##", $account_no, $message_success_card);
        $message_success_card = str_replace("##form_url##", $form_url, $message_success_card);

        return $message_success_card;
    }

    /**
     * 
     * Создание счёта в системе express-pay
     * 
     */
    public static function createInvoices() 
    {
        $paymentMethod_id = osc_sanitize_int(Params::getParam("paymentmethodid"));
        $paymentMethod = ExpressPayOptionsModel::newInstance()->findByPrimaryKey($paymentMethod_id);
        if($paymentMethod['isactive'] == 1)
        {
            $options = json_decode($paymentMethod['options']);
            $amount = Params::getParam("amount");
            $description = osc_esc_js(Params::getParam("description"));
            $extra = osc_esc_js(Params::getParam("extra"));
            $extra .= '|concept,'.$description;
            $extra .= '|product,'.$itemnumber;
            $itemnumber = osc_esc_js(Params::getParam("itemnumber"));

            $extra_array = osp_get_custom($extra);
            $email = $extra_array['email'];
            $user = User::newInstance()->findByEmail($email);
            $last_name = osc_esc_js($user['s_name']);
            //$first_name = sanitize_text_field($_REQUEST['first_name']);
            //$patronymic = sanitize_text_field($_REQUEST['patronymic']);
            //$phone = osc_esc_js($user['s_phone_mobile']);
            //$url = sanitize_text_field($_REQUEST['url']);
            //$info = sanitize_text_field(Params::getParam("info"));

            /*if ($options->SendSms)
            {
                $client_phone = preg_replace('/[^0-9]/', '', $phone);
                $client_phone = substr($client_phone, -9);
                $client_phone = "375$client_phone";
            }*/

            $accountNo = ExpressPayInvoiceModel::newInstance()->insertInvoice($amount, $description, $extra, $itemnumber, $paymentMethod_id);

            $signatureParams = array(
                "Token" => $options->Token,
                "ServiceId" => $options->ServiceId,
                "AccountNo" => $accountNo,
                "Amount" => $amount,
                "Currency" => 933,
                "Info" => $description,
                "ReturnType" => "json",
                "ReturnUrl" => osc_base_url(true),
                "FailUrl" => osc_base_url(true),
            );
            
            $baseurl = $options->TestMode == 1 ? $options->SandboxUrl : $options->ApiUrl;
            if ($paymentMethod['type'] == 'card') 
            {
                $signatureParams['Signature'] = self::computeSignature($signatureParams, $options->SecretWord, 'add-webcard-invoice');
                unset($signatureParams['Token']);

                $result = self::sendRequestPOST($baseurl."web_cardinvoices", $signatureParams);

                if(isset($result->ExpressPayInvoiceNo))
                {
                    $formUrl = $result->FormUrl;
                    header("HTTP/1.1 200 OK");
                    echo self::getCardMessage($options, $accountNo, $formUrl);
                    return;
                }
            }
            else 
            {
                $signatureParams["Surname"] = $last_name;
                $signatureParams["FirstName"] = $first_name;
                $signatureParams["Patronymic"] = $patronymic;
                $signatureParams["IsNameEditable"] = $options->CanChangeName;
                $signatureParams["IsAddressEditable"] = $options->CanChangeAddress;
                $signatureParams["IsAmountEditable"] = $options->CanChangeAmount;
                if($options->SendEmail) $signatureParams["EmailNotification"] = $email;
                if($options->SendSms) $signatureParams["SmsPhone"] = $client_phone;
                
                $signatureParams['Signature'] = self::computeSignature($signatureParams, $options->SecretWord, 'add-web-invoice');
                unset($signatureParams['Token']);

                $result = self::sendRequestPOST($baseurl."web_invoices", $signatureParams);

                if(isset($result->ExpressPayInvoiceNo))
                {
                    if ($paymentMethod['type'] == 'erip')
                    {
                        header("HTTP/1.1 200 OK");
                        echo self::getEripMessage($options, $accountNo, $invoiceUrl);
                        return;
                    }
                    else
                    {
                        header("HTTP/1.1 200 OK");
                        echo self::getEposMessage($options, $accountNo, $invoiceUrl);
                        return;
                    }
                }
            }
        }
        header('HTTP/1.1 405 Method Not Allowed');
        print $st = 'При выполнении запроса произошла непредвиденная ошибка. Пожалуйста, повторите запрос позже или обратитесь в службу технической поддержки магазина.';
        return;
    }

    /**
     * 
     * Обработка уведомления от express-pay
     * 
     */
    public static function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $dataJSON = (isset($_REQUEST['Data'])) ? $_REQUEST['Data'] : '';
            $dataJSON = stripcslashes($dataJSON);

            // Преобразование из json в array
            $data = array();
            try {
                $data = json_decode($dataJSON,true); 
            } 
            catch(Exception $e) {
                header('HTTP/1.1 400 Bad Request');
                print $st = 'FAILED | failed to decode data';
                return;
            }

            // Получение подписи
            $signature = (isset($_REQUEST['Signature'])) ? osc_esc_html($_REQUEST['Signature']) : '';

            if(isset($data['AccountNo'])){
                $accountNo = $data['AccountNo'];
                $invoice = ExpressPayInvoiceModel::newInstance()->findByPrimaryKey($accountNo);
                
                // Получение настрек для данного метода
                $paymentMethod = ExpressPayOptionsModel::newInstance()->findByPrimaryKey($invoice['options_id']);
                $options = json_decode($paymentMethod['options']);

                if ($options->UseSignatureForNotification == 1) {
                    $valid_signature = self::computeSignature(array("data" => $dataJSON), $options->SecretWordForNotification, 'notification');
                    if ($valid_signature == $signature) {
                    } else {                    
                        header('HTTP/1.1 403 FORBIDDEN');
                        print $st = 'FAILED | Access is denied';
                        return;
                    }
                }
                
                $cmdtype    = $data['CmdType'];
                $status     = $data['Status'];
                $amount     = $data['Amount'];

                if (isset($data['Created'])) {
                    ExpressPayInvoiceModel::newInstance()->updateInvoiceDateOfPayment($accountNo, $data['Created']);
                }
                switch ($cmdtype) {
                    case 1:
                        ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 1);
                        header("HTTP/1.1 200 OK");
                        print $st= 'OK | the notice is processed';
                        return;
                    case 2:
                        ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 5);
                        header("HTTP/1.1 200 OK");
                        print $st= 'OK | the notice is processed';
                        return;
                    case 3:
                        if(isset($status)){
                            switch($status){
                                case 1: // Ожидает оплату
                                    ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 1);
                                    break;
                                case 2: // Просрочен
                                    ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 2);
                                    break;
                                case 3: // Оплачен
                                case 6: // Оплачен с помощью банковской карты
                                    if($status == 3){
                                        ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 3);
                                    }
                                    else if($status == 6){
                                        ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 6);
                                    }
                                    $payment = ModelOSP::newInstance()->getPaymentByCode($invoice['id'], 'EXPRESSPAY');

                                    if (!$payment) {
                                        $extra = osp_get_custom($invoice['extra']);
                                        $product_type = explode('x', $invoice['itemnumber']);
                                        
                                        // SAVE TRANSACTION LOG
                                        $payment_id = ModelOSP::newInstance()->saveLog(
                                            $extra['concept'], //concept
                                            $accountNo, // transaction code
                                            $amount, //amount
                                            933, //currency
                                            $extra['email'], // payer's email
                                            $extra['user'], //user
                                            osp_create_cart_string($product_type[1], $extra['user'], $extra['itemid']), // cart string
                                            $product_type[0], //product type
                                            'EXPRESSPAY' //source
                                        ); 
        
                                        // Pay it!
                                        $payment_details = osp_prepare_payment_data($amount, $payment_id, $extra['user'], $product_type);   //amount, payment_id, user_id, product_type
                                        $pay_item = osp_pay_fee($payment_details);
                                    }
                                    break;
                                case 4: // Оплачен частично 
                                    ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 4);
                                    break;
                                case 5: // Отменен
                                    ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 5);
                                    break;
                                case 7: // Платеж возращен
                                    ExpressPayInvoiceModel::newInstance()->updateInvoiceStatus($accountNo, 7);
                                    break;
                                default:
                                    header('HTTP/1.1 400 Bad Request');
                                    print $st = 'FAILED | invalid status'; //Ошибка в параметрах
                                    $logs->log_error('processNotification','FAILED | Invalid status; Status - '.$status);
                                    return;
                            }
                            header("HTTP/1.1 200 OK");
                            print $st= 'OK | the notice is processed';
                            return;
                        }
                        break;
                    default:
                        header('HTTP/1.1 400 Bad Request');
                        print $st = 'FAILED | invalid cmdtype';
                        return;
                }
                header('HTTP/1.1 400 Bad Request');
                print $st = 'FAILED | the notice is not processed';
            }
        }
        else {		
            header('HTTP/1.1 405 Method Not Allowed');
            print $st = 'FAILED | request method not supported';
            return;
        }
    }
    
    /**
     * 
     * Отправка POST запроса
     * 
     */
    public static function sendRequestPOST($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    /**
     * 
     * Формирование цифровой подписи
     * 
     * @param array  $signatureParams Список передаваемых параметров
     * @param string $secretWord      Секретное слово
     * @param string $method          Метод формирования цифровой подписи
     * 
     * @return string $hash           Сформированная цифровая подпись
     * 
     */
    public static function computeSignature($signatureParams, $secretWord, $method)
    {
      
        $normalizedParams = array_change_key_case($signatureParams, CASE_LOWER);
        $mapping = array(
            "add-invoice" => array(
                "token",
                "accountno",
                "amount",
                "currency",
                "expiration",
                "info",
                "surname",
                "firstname",
                "patronymic",
                "city",
                "street",
                "house",
                "building",
                "apartment",
                "isnameeditable",
                "isaddresseditable",
                "isamounteditable"
            ),
            "get-details-invoice" => array(
                "token",
                "id"
            ),
            "cancel-invoice" => array(
                "token",
                "id"
            ),
            "status-invoice" => array(
                "token",
                "id"
            ),
            "get-list-invoices" => array(
                "token",
                "from",
                "to",
                "accountno",
                "status"
            ),
            "get-list-payments" => array(
                "token",
                "from",
                "to",
                "accountno"
            ),
            "get-details-payment" => array(
                "token",
                "id"
            ),
            "add-card-invoice"  =>  array(
                "token",
                "accountno",
                "expiration",
                "amount",
                "currency",
                "info",
                "returnurl",
                "failurl",
                "language",
                "pageview",
                "sessiontimeoutsecs",
                "expirationdate"
            ),
            "card-invoice-form"  =>  array(
                "token",
                "cardinvoiceno"
            ),
            "status-card-invoice" => array(
                "token",
                "cardinvoiceno",
                "language"
            ),
            "reverse-card-invoice" => array(
                "token",
                "cardinvoiceno"
            ),
            "get-qr-code"          => array(
                "token",
                "invoiceid",
                "viewtype",
                "imagewidth",
                "imageheight"
            ),
            "add-web-invoice"      => array(
                "token",
                "serviceid",
                "accountno",
                "amount",
                "currency",
                "expiration",
                "info",
                "surname",
                "firstname",
                "patronymic",
                "city",
                "street",
                "house",
                "building",
                "apartment",
                "isnameeditable",
                "isaddresseditable",
                "isamounteditable",
                "emailnotification",
                "smsphone",
                "returntype",
                "returnurl",
                "failurl"
            ),
            "add-webcard-invoice" => array(
                "token",
                "serviceid",
                "accountno",
                "expiration",
                "amount",
                "currency",
                "info",
                "returnurl",
                "failurl",
                "language",
                "sessiontimeoutsecs",
                "expirationdate",
                "returntype"
            ),
            "response-web-invoice" => array(
                "token",
                "expresspayaccountnumber",
                "expresspayinvoiceno"
            ),
            "notification"         => array(
                "data"
            )
        );
        $apiMethod = $mapping[$method];
        $result = "";
        foreach ($apiMethod as $item) {
            $result .= $normalizedParams[$item];
        }
        $hash = strtoupper(hash_hmac('sha1', $result, $secretWord));
        return $hash;
    }
}?>