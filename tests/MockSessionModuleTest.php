<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\Injector;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class MockSessionModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testModule()
    {
        $module = new MockSessionModule();
        $injector = new Injector($module, $_ENV['TMP_DIR']);
        $instance = $injector->getInstance(SessionInterface::class);

        $this->assertInstanceOf(SessionInterface::class, $instance);

        $clazz = new \ReflectionClass($instance);
        $prop = $clazz->getProperty('storage');
        $prop->setAccessible(true);
        $storage = $prop->getValue($instance);

        $this->assertInstanceOf(MockArraySessionStorage::class, $storage);
    }
}
