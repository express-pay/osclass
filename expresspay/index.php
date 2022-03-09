<?php
/*
Plugin Name: ExpressPay Payment Module
Short Name: expresspay
Plugin URI: https://express-pay.by/extensions/osclass/
Description: CMS Osclass extension for integration with the Express Payments service. The extension allows you to accept payments using ERIP, bank cards and E-POS.
Version: 1.0.0
Author: LLC «TriIncom»
Author URI: https://express-pay.by
Text Domain: osclass_expresspay
Domain Path: /languages
*/
if (defined('ABSPATH')) exit;
require_once __DIR__ . "/oc-load.php";

/*
 * ==========================================================================
 *  INSTALL
 * ==========================================================================
 */
function expresspay_install() {
    expresspay_module_import_sql(__DIR__ . "/assets/model/install.sql");
    osc_set_preference('expresspay_enabled', '1', 'plugin-osclass_pay', 'BOOLEAN');
    osc_set_preference("version", "1.0.0", "plugin_expresspay");
    osc_reset_preferences();

}
osc_register_plugin(osc_plugin_path(__FILE__), 'expresspay_install');

/*
 * ==========================================================================
 *  UNINSTALL
 * ==========================================================================
 */
function expresspay_uninstall() {
    expresspay_module_import_sql(__DIR__ . "/assets/model/uninstall.sql");
    osc_delete_preference("expresspay_enabled", "plugin-osclass_pay");
    osc_delete_preference("version", "plugin_expresspay");
    osc_reset_preferences();
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'expresspay_uninstall');

/*
 * ==========================================================================
 *  Administrator Menus
 * ==========================================================================
 */
function expresspay_menu() {
    osc_add_admin_menu_page( 
        __('Express Pay', 'expresspay'), 
        osc_route_admin_url('expresspay-admin-home'),
        'expresspay',
        'administrator'
    );
    osc_add_admin_submenu_page(
        'expresspay', 
        __('Home', 'expresspay'), 
        osc_route_admin_url('expresspay-admin-home'), 
        'expresspay-admin-home', 
        'administrator'
    );
    osc_add_admin_submenu_page(
        'expresspay', 
        __('Invoices and payemnts', 'expresspay'), 
        osc_route_admin_url('expresspay-admin-invoices-list'), 
        'expresspay-admin-invoices-list', 
        'administrator'
    );
    osc_add_admin_submenu_page(
        'expresspay', 
        __('Settings', 'expresspay'), 
        osc_route_admin_url('expresspay-admin-options-list'), 
        'expresspay-admin-options-list', 
        'administrator'
    );
}
osc_add_hook('admin_menu_init', 'expresspay_menu');

/*
 * ==========================================================================
 * Configure
 * ==========================================================================
 */
function expresspay_admin() {
    osc_redirect_to(osc_route_admin_url('expresspay-admin-home'));
}
osc_add_hook(osc_plugin_path(__FILE__)."_configure", 'expresspay_admin') ;

/*
 * ==========================================================================
 * Lib
 * ==========================================================================
 */
function expresspay_load_lib() {
	osc_enqueue_style('expresspay-payment-style', expresspay_assets_url('css/payment.css?v='.osp_param('version')));
}
osc_add_hook('init', 'expresspay_load_lib');

function expresspay_admin_load_lib() {
	osc_enqueue_style('expresspay-admin-style', expresspay_assets_url('css/admin.css?v='.osp_param('version')));
    osc_register_script('expresspay-admin-script', expresspay_assets_url('js/admin.js?v='.osp_param('version')));
    osc_enqueue_script('expresspay-admin-script');
}
osc_add_hook('init_admin', 'expresspay_admin_load_lib');

/*
 * ==========================================================================
 *  Controller
 * ==========================================================================
 */
function expresspay_controller()
{
    switch (Params::getParam("route")) {
        case "expresspay-invoices-list":    
            $do = new ExpressPayInvoicesController();
            $do->doInvoicesList();
            break;
        case "expresspay-invoice":    
            $do = new ExpressPayInvoicesController();
            $do->doInvoice();
            break;
    }
}
osc_add_hook("custom_controller", "expresspay_controller");

/*
 * ==========================================================================
 *  Controller Admin
 * ==========================================================================
 */
function expresspay_admin_controller()
{
    switch (Params::getParam("route")) {
        case "expresspay-admin-invoices-list":    
            $do = new ExpressPayInvoicesController();
            $do->doInvoicesList();
            break;

        case "expresspay-admin-options-list":    
            $do = new ExpressPayOptionsController();
            $do->doOptionsList();
            break;
        case "expresspay-admin-options":    
            $do = new ExpressPayOptionsController();
            $do->doOptions();
            break;
        case "expresspay-admin-options-save":    
            $do = new ExpressPayOptionsController();
            $do->doSaveOptions();
            break;
    }
}
osc_add_hook("renderplugin_controller", "expresspay_admin_controller");

/*
 * ==========================================================================
 *  AJAX
 * ==========================================================================
 */
osc_add_hook('ajax_expresspay_createInvoices', array('ExpresspayPayment', 'createInvoices'));
osc_add_hook('ajax_expresspay_processPayment', array('ExpresspayPayment', 'processPayment'));

osc_add_hook('ajax_admin_expresspay_optionEdit', array('ExpressPayOptionsController', 'optionEdit'));

/*
 * ==========================================================================
 *  ROUTES Admin
 * ==========================================================================
 */
osc_add_route(
    'expresspay-admin-home', 
    'expresspay/admin/home/', 
    'expresspay/admin/home/',
    expresspay_name(). '/views/admin/home.php'
);

/*
 *  Routes invoices
 */
osc_add_route(
    'expresspay-admin-invoices-list', 
    'expresspay/admin/invoices/list/', 
    'expresspay/admin/invoices/list/', 
    expresspay_name().'/views/admin/invoices_list.php'
);

/*
 *  Routes options
 */
osc_add_route(
    'expresspay-admin-options-list', 
    'expresspay/admin/options/list/',
    'expresspay/admin/options/list/',
    expresspay_name().'/views/admin/options_list.php'
);
osc_add_route(
    'expresspay-admin-options', 
    'expresspay/admin/options/', 
    'expresspay/admin/options/', 
    expresspay_name().'/views/admin/options.php'
);
osc_add_route(
    'expresspay-admin-options-save', 
    'expresspay/admin/options/save/',
    'expresspay/admin/options/save/',
    expresspay_name().'/views/admin/options_list.php'
);
?>