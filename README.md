# wilon/exception

[![Packagist][badge_package]][link-packagist]
[![Packagist Release][badge_release]][link-packagist]
[![Packagist Downloads][badge_downloads]][link-packagist]

[badge_package]:      https://img.shields.io/badge/package-wilon/exception-blue.svg?style=flat-square
[badge_release]:      https://img.shields.io/packagist/v/wilon/exception.svg?style=flat-square
[badge_downloads]:    https://img.shields.io/packagist/dt/wilon/exception.svg?style=flat-square
[link-packagist]:     https://packagist.org/packages/wilon/exception

Better exception output & write log. Like Laravel.

### Installation & loading

`php -v >=5.3.9` Run:  `composer require wilon/exception:~0.1`

`php -v >=5.5.9` Run:  `composer require wilon/exception`

### Bootstrap

```php
    (new Wilon\Exception\Handler)->bootstrap();
    // Set error_reporting(-1) & Show debug.
    // Write log to ./exceptions.log
```

Better :

```php

    $errorReporting = E_ALL ^ E_NOTICE;
    $showErrorInfo = true;

    (new Wilon\Exception\Handler)
        ->bootstrap($errorReporting, $showErrorInfo);

     // Set error_reporting(E_ALL ^ E_NOTICE) & Show debug.
     // Write log to ./exceptions.log .
```

Or more Settings:

```php

    $loggerName = 'exceptions';
    $loggerFile = __DIR__ . '/exceptions.log';
    $errorReporting = E_ALL ^ E_NOTICE;
    $showErrorInfo = true;
    
    (new Wilon\Exception\Handler)
        ->setLogger($loggerName, $loggerFile)
        ->bootstrap($errorReporting, $showErrorInfo);
```

### Funtion Desc

>  setLogger ( string $loggerName, string $loggerFile)

*Set Monolog*

* string $loggerName

    `$logger = new Logger($loggerName);`

* string $loggerFile

    `$logger->pushHandler(new StreamHandler($loggerFile, Logger::WARNING));`

>  bootstrap (  [ int $level [, boolean $show] )

*Sets which PHP errors are reported*

* int $level

    The new `error_reporting` level.

* string $show

    If is `true`, show debug.

