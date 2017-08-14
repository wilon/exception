# wilon/exception

Better exception output & write log. Like Laravel.

### Installation & loading

`php -v >=5.3.9` Run:  `composer require wilon/exception:0.1.1`

`php -v >=5.5.9` Run:  `composer require wilon/exception`

### Bootstrap

```php
    (new Wilon\Exception\Handler)->bootstrap();
     // Set error_reporting(-1);
     // Write log to ./exceptions.log
```

Or :

```php
    (new Wilon\Exception\Handler)->bootstrap(E_ALL ^ E_NOTICE);
     // Set error_reporting(E_ALL ^ E_NOTICE);
     // Write log to ./exceptions.log .
```

Or more Settings:

```php
    (new Wilon\Exception\Handler)
        ->setLogger('exceptions', __DIR__ . '/exceptions.log')
        ->bootstrap(E_ALL);
```

### Funtion Desc

>  setLogger ( string $loggerName, string $loggerFile)

*Set Monolog*

* string $loggerName

    `$logger = new Logger($loggerName);`

* string $loggerFile

    `$logger->pushHandler(new StreamHandler($loggerFile, Logger::WARNING));`

>  bootstrap (  [ int $level [, string $test] )

*Sets which PHP errors are reported*

* int $level

    The new `error_reporting` level.

* string $test

    If is `testing`, just test this package.

