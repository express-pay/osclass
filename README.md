# Расширение Osclass сервиса «Экспресс Платежи»
Расширение CMS Osclass для интеграции с сервисом «Экспресс Платежи». Расширение позволяет производить прием платежей с помощью ЕРИП, банковских карт и E-POS.

<a href="https://downgit.github.io/#/home?url=https://github.com/express-pay/osclass/tree/main/expresspay">Скачать ZIP</a><br/>
<a href="https://www.youtube.com/c/express-pay-by">Наш Youtube канал с опубликованными видео по расширениям</a>
## Минимальные требования для установки плагина:

* Osclass v3.3.1 и выше;
* Osclass Pay Plugin v1.8.4 и выше.

## Добавление кнопки оплаты в плагин Osclass Pay Plugin v3.4.4 и ниже
Для отображении кнопки оплаты необходимо изменить файл \oc-content\plugins\osclass_pay\functions.php добавив в конец функции osp_buttons следующие строчки:<br>
```php
if(class_exists('ExpresspayPayment') && osp_param('expresspay_enabled') == 1) {
	ExpresspayPayment::button($amount, $description, $itemnumber, $extra_array);
}
```
в конец функции osp_buttons_js следующие строчки:<br>
```php
if(class_exists('ExpresspayPayment') && osp_param('expresspay_enabled') == 1) {
   	ExpresspayPayment::dialogJS();
}
```
## Адрес для обработки URL уведомлений от сервиса «Экспресс Платежи»
```
http://{адрес_сайта}/index.php?page=ajax&action=runhook&hook=expresspay_processPayment
```
