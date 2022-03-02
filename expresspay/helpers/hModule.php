<?php

/**
 * Получение названия плагина.
 */
function expresspay_name()
{
    return osc_esc_html(EXPRESSPAY_PLUGIN);
}
/**
 * 
 * Получение URL плагина.
 * 
 * @param string $url адресс
 * 
 */
function expresspay_url($url = '')
{
    return osc_esc_html(EXPRESSPAY_PLUGIN_URL. $url);
}
/**
 * 
 * Получение URL ресурса.
 * 
 * @param string $assets ресурс
 * 
 */
function expresspay_assets_url($assets = '')
{
    return osc_esc_html(EXPRESSPAY_PLUGIN_URL. 'assets/' . $assets);
}
/**
 * 
 * Получение вью из файла.
 * 
 * @param string $name Название файла вью
 * @param array  $args Аргументы для передачи на вью
 * 
 */
function expresspay_view($name, array $args = array())
{
    foreach ($args as $key => $val) {
        $$key = $val;
    }

    $file = EXPRESSPAY_PLUGIN_DIR . 'views/' . $name . '.php';

    include($file);
}
/**
 * Получение названия плагина
 */
function expresspay_plugin() {
    return 'expresspay';
}

/**
 * 
 * Адрес для обработки URL уведомлений от сервиса «Экспресс Платежи»
 * 
 */
function expresspay_url_notifications()
{
    return osc_base_url().'index.php?page=ajax&action=runhook&hook=expresspay_processPayment';
}

/**
 * 
 * Проверка маршрута
 * 
 * @param string $route Название файла вью
 * 
 */
function expresspay_is_route($route = "")
{
    return Params::getParam("route") == $route;
}

///////////////////////////////////////////////////////////////////
function expresspay_get_invoices_list()
{
    return View::newInstance()->_get("expresspay_invoices_list");
}
function expresspay_get_invoices_count()
{
    return View::newInstance()->_get("expresspay_invoices_count");
}
///////////////////////////////////////////////////////////////////
function expresspay_get_options()
{
    return View::newInstance()->_get("expresspay_options");
}
function expresspay_get_options_id()
{
    return View::newInstance()->_get("expresspay_options_id");
}
function expresspay_get_options_list()
{
    return View::newInstance()->_get("expresspay_options_list");
}
function expresspay_get_options_count()
{
    return View::newInstance()->_get("expresspay_options_count");
}
///////////////////////////////////////////////////////////////////