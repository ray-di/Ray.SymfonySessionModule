<?php

namespace Ray\SymfonySessionModule;

use Ray\SymfonySessionModule\Annotation\Sessional;

/**
 * @Sessional
 */
class FakeSessionalClassConsumer
{
    use SessionInject;

    public function sessionIsStarted()
    {
        return $this->session->isStarted();
    }
}
