# Авторизация с помощью EMAIL для Bitrix
Модуль позволяет автоматически авторизовываться с помощью email в 1С-Битрикс.

Ссылка на модуль в маркетплейсе битрикса: [dev2fun.authemail](https://marketplace.1c-bitrix.ru/solutions/dev2fun.authemail/)

## Настройка

Настройка осуществляется на странице настроек модуля в админке битрикса.
Каждое поле представляет собой 2 ключа `EmailInputName` и `PasswordInputName` разделенные `:`, пример: `USER_LOGIN:USER_PASSWORD`
* `EmailInputName` - имя input поля с email или логином
* `PasswordInputName` - имя input поля с паролем

## Как работает модуль

Модуль срабатывает на POST-запросе, где ищет наличие поля и пользователя из `EmailInputName`, в качестве пароля использует `PasswordInputName`, далее срабатывает стандартный механизм авторизации пользователя (который вшит в битрикс).

_Следует понимать, что модуль находит только первое вхождение._

## По умолчанию
* `EmailInputName` - равен данным из `USER_LOGIN`
* `PasswordInputName` - равен данным из `USER_PASSWORD`

## Шаги первой установки

1. Узнать кодировку своего сайта (utf8 или win1251)
1. Скопировать папку `dev2fun.authemail` из папки нужной кодировки в папку bitrix/modules
1. Перейти в админку сайта на страницу "Решения Маркетплейс" (/bitrix/admin/partner_modules.php)
1. Установить модуль
1. Настроить модуль
1. Поблагодарить автора :)
1. Использовать

## Шаги обновлений
Т.к. у не активных лицензии updater битрикса не доступен, то нужно проделать след. шаги.

1. Узнать кодировку своего сайта (utf8 или win1251)
1. Скопировать папку `dev2fun.authemail` из папки нужной кодировки в папку `bitrix/modules` с заменой всех файлов
1. Сбросить кэш
1. Поблагодарить автора :)
1. Использовать

## Donate

|                    |                                                           |
|--------------------|-----------------------------------------------------------|
| На карту (РФ)      | [Tinkoff](https://www.tinkoff.ru/cf/36wVfnMf7mo)          |
| Yandex.Money       | [410011413398643](https://yoomoney.ru/to/410011413398643) |
| Webmoney WMR (rub) | R218843696478                                             |
| Webmoney WMU (uah) | U135571355496                                             |
| Webmoney WMZ (usd) | Z418373807413                                             |
| Webmoney WME (eur) | E331660539346                                             |
| Webmoney WMX (btc) | X740165207511                                             |
| Webmoney WML (ltc) | L718094223715                                             |
| Webmoney WMH (bch) | H526457512792                                             |
| PayPal             | [@darkfriend](https://www.paypal.me/darkfriend)           |
| Payeer             | P93175651                                                 |
| Bitcoin            | 15Veahdvoqg3AFx3FvvKL4KEfZb6xZiM6n                        |
| Litecoin           | LRN5cssgwrGWMnQruumfV2V7wySoRu7A5t                        |
| Ethereum           | 0xe287Ac7150a087e582ab223532928a89c7A7E7B2                |
| BitcoinCash        | bitcoincash:qrl8p6jxgpkeupmvyukg6mnkeafs9fl5dszft9fw9w    |
