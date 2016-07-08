# Ray.SymfonySessionModule

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.SymfonySessionModule/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.SymfonySessionModule/?branch=1.x)
[![Code Coverage](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.SymfonySessionModule/badges/coverage.png?b=1.x)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.SymfonySessionModule/?branch=1.x)
[![Build Status](https://travis-ci.org/kawanamiyuu/Ray.SymfonySessionModule.svg?branch=1.x)](https://travis-ci.org/kawanamiyuu/Ray.SymfonySessionModule)
[![Packagist](https://img.shields.io/packagist/v/ray/symfony-session-module.svg?maxAge=3600)](https://packagist.org/packages/ray/symfony-session-module)
[![Packagist](https://img.shields.io/packagist/l/ray/symfony-session-module.svg?maxAge=3600)](https://github.com/kawanamiyuu/Ray.SymfonySessionModule/blob/1.x/LICENSE)

A [Symfony Session](https://github.com/symfony/http-foundation/tree/master/Session) Module for [Ray.Di](https://github.com/ray-di/Ray.Di)

## Installation

### Composer install

```bash
$ composer require ray/symfony-session-module
```

### Module install

#### PdoSessionModule (e.g. for MySQL)

1. Create `sessions` table in your database.

    ```bash
    $ ./bin/initPdoSession 'mysql:host=localhost;dbname=mydb' 'myname' 'mypass'
    ```

2. Install module.

    ```php
    use Ray\Di\AbstractModule;
    use Ray\SymfonySessionModule\PdoSessionModule;

    class AppModule extends AbstractModule
    {
        protected function configure()
        {
            $pdo = new \PDO('mysql:host=localhost;dbname=mydb', 'myname', 'mypass');
            $options = [
                'cookie_secure' => 1,
                'cookie_httponly' => 1,
                'cookie_lifetime' => 60 * 60 * 24
            ];

            $this->install(new PdoSessionModule($pdo, $options));
        }
    }
    ```

## DI trait

* [SessionInject](https://github.com/kawanamiyuu/Ray.SymfonySessionModule/blob/1.x/src/SessionInject.php) for `Symfony\Component\HttpFoundation\Session\SessionInterface` interface

## Session lifetime management

For each request, your application can check whether session cookie is expired or not. If session cookie is expired, `SessionExpiredException` is thrown.

### Configuration

1. Install `SessionalModule`.

    ```php
    use Ray\Di\AbstractModule;
    use Ray\SymfonySessionModule\PdoSessionModule;
    use Ray\SymfonySessionModule\SessionalModule;

    class AppModule extends AbstractModule
    {
        protected function configure()
        {
            $this->install(new PdoSessionModule($pdo, $options));
            $this->install(new SessionalModule); // <--
        }
    }
    ```

2. Mark the class/method with `@Sessional`.

    When any method in the class marked with `@Sessional` is executed, session cookie will be checked.

    ```php
    use Ray\SymfonySessionModule\Annotation\Sessional;

    /**
     * @Sessional
     */
    class SomeController
    {
        public function fooAction()
        {
            // session is automatically started and session cookie is checked.
        }
    }
    ```

    When the method marked with `@Sessional` is executed, session cookie will be checked.

    ```php
    use Ray\SymfonySessionModule\Annotation\Sessional;

    class SomeController
    {
        /**
         * @Sessional
         */
        public function fooAction()
        {
            // session is automatically started and session cookie is checked.
        }

        public function barAction()
        {
            // session is NOT started.
        }
    }
    ```

## Unit Testing

`MockSessionModule` provides in-memory session mechanism for unit testing. Any session data are not persisted to the storage.

```php
use Ray\Di\AbstractModule;
use Ray\SymfonySessionModule\MockSessionModule;
use Ray\SymfonySessionModule\SessionalModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new MockSessionModule); // <--
        $this->install(new SessionalModule);
    }
}
```

## Demo

```bash
$ php docs/demo/run.php
// Session is started!
```

## Requirements

* PHP 5.6+
* hhvm

## More Documents

* the official documentation about [Session Management](http://symfony.com/doc/current/components/http_foundation/sessions.html) of Symfony
