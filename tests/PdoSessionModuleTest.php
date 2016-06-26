<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\Injector;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class PdoSessionModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testModule()
    {
        $pdo = new \PDO('sqlite::memory:');
        $lifetime = 60 * 60 * 24; // 1 day

        $module = new PdoSessionModule($pdo, ['cookie_lifetime' => $lifetime]);
        $injector = new Injector($module, $_ENV['TMP_DIR']);
        $instance = $injector->getInstance(SessionInterface::class);

        $this->assertInstanceOf(SessionInterface::class, $instance);
        /* @var $instance SessionInterface */

        $clazz = new \ReflectionClass($instance);
        $prop = $clazz->getProperty('storage');
        $prop->setAccessible(true);
        $storage = $prop->getValue($instance);
        /* @var $storage NativeSessionStorage */

        $proxy = $storage->getSaveHandler();

        $clazz = new \ReflectionClass($proxy);
        $prop = $clazz->getProperty('handler');
        $prop->setAccessible(true);
        $handler = $prop->getValue($proxy);

        $this->assertInstanceOf(PdoSessionHandler::class, $handler);
        /* @var $handler PdoSessionHandler */

        $handler->createTable();

        $instance->start();

        $this->assertEquals($lifetime, ini_get('session.cookie_lifetime'));
        $this->assertEquals($lifetime, $instance->getMetadataBag()->getLifetime());
    }
}
