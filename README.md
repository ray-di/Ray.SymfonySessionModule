# Ray.SymfonySessionModule

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.SymfonySessionModule/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.SymfonySessionModule/?branch=1.x)
[![Code Coverage](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.SymfonySessionModule/badges/coverage.png?b=1.x)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.SymfonySessionModule/?branch=1.x)
[![Build Status](https://travis-ci.org/kawanamiyuu/Ray.SymfonySessionModule.svg?branch=1.x)](https://travis-ci.org/kawanamiyuu/Ray.SymfonySessionModule)

A [Symfony Session](https://github.com/symfony/http-foundation/tree/master/Session) Module for [Ray.Di](https://github.com/ray-di/Ray.Di)

## Installation

### Composer install

```bash
$ composer require ray/symfony-session-module
```

### Module install

```php
use Ray\Di\AbstractModule;
use Ray\SymfonySessionModule\PdoSessionModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $pdo = new \PDO('sqlite::memory:');
        $options = [
            'cookie_lifetime' => 60 * 60 * 24
        ];

        $this->install(new PdoSessionModule($pdo, $options));
    }
}
```

## DI trait

* [SessionInject](https://github.com/kawanamiyuu/Ray.SymfonySessionModule/blob/1.x/src/SessionInject.php) for `Symfony\Component\HttpFoundation\Session\SessionInterface` interface

## Demo

```bash
$ php docs/demo/run.php
// Session is started!
```

## Requirements

* PHP 5.6+
* hhvm
