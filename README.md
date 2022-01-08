# Шифрование данных с помощью AES

![Package version](https://img.shields.io/github/v/release/motokraft/encryptaes)
![Total Downloads](https://img.shields.io/packagist/dt/motokraft/encryptaes)
![PHP Version](https://img.shields.io/packagist/php-v/motokraft/encryptaes)
![Repository Size](https://img.shields.io/github/repo-size/motokraft/encryptaes)
![License](https://img.shields.io/packagist/l/motokraft/encryptaes)

## Установка

Библиотека устанавливается с помощью пакетного менеджера [**Composer**](https://getcomposer.org/)

Добавьте библиотеку в файл `composer.json` вашего проекта:

```json
{
    "require": {
        "motokraft/encryptaes": "^1.0.0"
    }
}
```

или выполните команду в терминале

```
$ php composer require motokraft/encryptaes
```

Включите автозагрузчик Composer в код проекта:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Примеры инициализации

```php
use \Motokraft\EncryptAes\EncryptAes;
$aes = new EncryptAes;
```

## Документация

Перейдите на страницу [**Wiki**](https://github.com/motokraft/encryptaes/wiki) что бы получить подробную документацию об использовании библиотеки с примерами.

## Лицензия

Эта библиотека находится под лицензией MIT License.