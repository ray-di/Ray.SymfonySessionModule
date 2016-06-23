<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\AbstractModule;
use Ray\SymfonySessionModule\Annotation\Sessional;

class SessionalModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // Class annotated with @Sessional
        $this->bindInterceptor(
            $this->matcher->annotatedWith(Sessional::class),
            $this->matcher->any(),
            [SessionalInterceptor::class]
        );

        // Method annotated with @Sessional
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(Sessional::class),
            [SessionalInterceptor::class]
        );
    }
}
