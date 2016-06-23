<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\AbstractModule;

class FakeAppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new MockSessionModule);
        $this->install(new SessionalModule);
    }
}
