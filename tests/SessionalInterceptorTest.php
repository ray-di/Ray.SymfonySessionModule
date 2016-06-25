<?php

namespace Ray\SymfonySessionModule;

use Ray\Aop\Arguments;
use Ray\Aop\ReflectiveMethodInvocation;
use Ray\Di\Injector;
use Ray\SymfonySessionModule\Exception\SessionExpiredException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class SessionalInterceptorTest extends \PHPUnit_Framework_TestCase
{
    public function testSessionStarted()
    {
        $injector = new Injector(new FakeAppModule, $_ENV['TMP_DIR']);

        $interceptor = $injector->getInstance(SessionalInterceptor::class);
        $object = $injector->getInstance(FakeConsumer::class);

        $invocation = new ReflectiveMethodInvocation(
            $object,
            new \ReflectionMethod($object, 'sessionIsStarted'),
            new Arguments([]),
            [$interceptor]
        );

        $sessionIsStarted = $invocation->proceed();
        $this->assertTrue($sessionIsStarted);
    }

    public function testSessionExpired()
    {
        $injector = new Injector(new FakeAppModule, $_ENV['TMP_DIR']);

        $session = $injector->getInstance(SessionInterface::class);
        /* @var $session SessionInterface */

        $clazz = new \ReflectionClass($session);
        $prop = $clazz->getProperty('storage');
        $prop->setAccessible(true);
        $storage = $prop->getValue($session);
        /* @var $storage NativeSessionStorage */

        $storage->setMetadataBag(new FakeMetadataBag);

        $interceptor = $injector->getInstance(SessionalInterceptor::class);
        /* @var $interceptor SessionalInterceptor */
        $interceptor->setSession($session);

        $object = $injector->getInstance(FakeConsumer::class);

        $invocation = new ReflectiveMethodInvocation(
            $object,
            new \ReflectionMethod($object, 'sessionIsStarted'),
            new Arguments([]),
            [$interceptor]
        );

        $this->expectException(SessionExpiredException::class);
        $invocation->proceed();
    }
}
