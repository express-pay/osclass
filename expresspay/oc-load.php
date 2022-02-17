<?php
define('EXPRESSPAY_PLUGIN', 'expresspay');
define('EXPRESSPAY_PLUGIN_PATH', __DIR__. '/');
define('EXPRESSPAY_PLUGIN_URL', osc_base_url().'oc-content/plugins/expresspay/');

require_once EXPRESSPAY_PLUGIN_PATH . "helpers/hUtils.php";
require_once EXPRESSPAY_PLUGIN_PATH . "helpers/hModule.php";
require_once EXPRESSPAY_PLUGIN_PATH . "classes/expresspay/models/Options.php";
require_once EXPRESSPAY_PLUGIN_PATH . "classes/expresspay/models/Invoices.php";
require_once EXPRESSPAY_PLUGIN_PATH . "classes/expresspay/controllers/Invoices.php";
require_once EXPRESSPAY_PLUGIN_PATH . "classes/expresspay/controllers/Options.php";
require_once EXPRESSPAY_PLUGIN_PATH . 'classes/expresspay/ExpresspayPayment.php';