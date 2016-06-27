<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Ray\Di\Injector;
use Ray\SymfonySessionModule\Annotation\Sessional;
use Ray\SymfonySessionModule\PdoSessionModule;
use Ray\SymfonySessionModule\SessionalModule;
use Ray\SymfonySessionModule\SessionInject;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

$loader = require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
/* @var $loader \Composer\Autoload\ClassLoader */
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

/**
 * @Sessional
 */
class Fake
{
    use SessionInject;

    public function foo()
    {
        return $this->session->isStarted();
    }
}

$pdo = new \PDO('sqlite::memory:');
$options = [
    'cookie_lifetime' => 60 * 60 * 24
];

$injector = (new Injector(new SessionalModule(new PdoSessionModule($pdo, $options))));

$handler = $injector->getInstance(\SessionHandlerInterface::class);
/* @var $handler PdoSessionHandler */
$handler->createTable();

$fake = $injector->getInstance(Fake::class);
/* @var $fake Fake */
echo($fake->foo() ? 'Session is started!' : 'Session is NOT started!!') . PHP_EOL;
