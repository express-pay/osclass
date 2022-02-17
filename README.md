# Расширение Osclass сервиса «Экспресс Платежи»
<p>Расширение CMS Osclass для интеграции с сервисом «Экспресс Платежи». Расширение позволяет производить прием платежей с помощью ЕРИП, банковских карт и e-POS.</p>
[Скачать ZIP](https://downgit.github.io/#/home?url=https://github.com/express-pay/osclass/tree/main/expresspay)
<h2>Минимальные требования для установки плагина:</h2>
<ul>
  <li>Osclass v.3.3 и выше;</li>
  <li>Osclass Pay Plugin.</li>
</ul>
<h2>Добавление кнопки оплаты</h2>
Для отображении кнопки оплаты необходимо изменить файл \oc-content\plugins\osclass_pay\functions.php добавив в конец функции osp_buttons следующие строчки:<br>
```php
if(osp_param('expresspay_enabled') == 1) {
	ExpresspayPayment::button($amount, $description, $itemnumber, $extra_array);
}
```
<br>
в конец функции osp_buttons_js следующие строчки:<br>
```php
if(osp_param('expresspay_enabled') == 1) {
   	ExpresspayPayment::dialogJS();
}
```
<h2>Адрес для URL уведомлений</h2>
http://{адрес_сайта}/index.php?page=ajax&action=runhook&hook=expresspay_processPayment&method_id={id_способа_оплаты}
