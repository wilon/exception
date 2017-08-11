# wilon/exception

Better exception output & write log. Like Laravel.

## Installation & loading

`php -v >=5.3.9` Run:  `composer require wilon/exception:0.1`

`php -v >=5.5.9` Run:  `composer require wilon/exception`

## Bootstrap

```php
<?php
(new Wilon\Exception\Handler)->bootstrap();
```

Or more Settings:

```php
<?php
(new Wilon\Exception\Handler)
    ->setLogger('exceptions', __DIR__ . '/exceptions.log')
    ->bootstrap(-1, 'testing');
```

