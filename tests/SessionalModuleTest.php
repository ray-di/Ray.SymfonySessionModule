<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\Injector;

class SessionalModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testClassAnnotatedWith()
    {
        $injector = new Injector(new FakeAppModule, $_ENV['TMP_DIR']);
        $consumer = $injector->getInstance(FakeSessionalClassConsumer::class);
        /* @var $consumer FakeSessionalClassConsumer */

        $this->assertTrue($consumer->sessionIsStarted());
    }

    public function testMethodAnnotatedWith()
    {
        $injector = new Injector(new FakeAppModule, $_ENV['TMP_DIR']);
        $consumer = $injector->getInstance(FakeSessionalMethodConsumer::class);
        /* @var $consumer FakeSessionalMethodConsumer */

        $this->assertTrue($consumer->sessionIsStarted());
    }

    public function testMethodNotAnnotatedWith()
    {
        $injector = new Injector(new FakeAppModule, $_ENV['TMP_DIR']);
        $consumer = $injector->getInstance(FakeSessionalMethodConsumer::class);
        /* @var $consumer FakeSessionalMethodConsumer */

        $this->assertTrue($consumer->sessionIsNotStarted());
    }
}
