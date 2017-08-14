# wilon/exception

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
    (new Wilon\Exception\Handler)
        ->bootstrap(E_ALL ^ E_NOTICE, $_ENV['APP_DEBUG']);
     // Set error_reporting(E_ALL ^ E_NOTICE) & Show debug.
     // Write log to ./exceptions.log .
```

Or more Settings:

```php
    (new Wilon\Exception\Handler)
        ->setLogger('exceptions', __DIR__ . '/exceptions.log')
        ->bootstrap(E_ALL, false);
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

