<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\AbstractModule;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class MockSessionModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(SessionInterface::class)->toInstance(new Session(new MockArraySessionStorage));
    }
}
