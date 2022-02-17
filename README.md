# Расширение Osclass сервиса «Экспресс Платежи»
Расширение CMS Osclass для интеграции с сервисом «Экспресс Платежи». Расширение позволяет производить прием платежей с помощью ЕРИП, банковских карт и e-POS.

<a href="https://downgit.github.io/#/home?url=https://github.com/express-pay/osclass/tree/main/expresspay">Скачать ZIP</a>
## Минимальные требования для установки плагина:

* Osclass v.3.3 и выше;
* Osclass Pay Plugin.

## Добавление кнопки оплаты
Для отображении кнопки оплаты необходимо изменить файл \oc-content\plugins\osclass_pay\functions.php добавив в конец функции osp_buttons следующие строчки:<br>
```php
if(osp_param('expresspay_enabled') == 1) {
	ExpresspayPayment::button($amount, $description, $itemnumber, $extra_array);
}
```
в конец функции osp_buttons_js следующие строчки:<br>
```php
if(osp_param('expresspay_enabled') == 1) {
   	ExpresspayPayment::dialogJS();
}
```
## Адрес для URL уведомлений
http://{адрес_сайта}/index.php?page=ajax&action=runhook&hook=expresspay_processPayment&method_id={id_способа_оплаты}
