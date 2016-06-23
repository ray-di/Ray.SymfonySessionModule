<?php

namespace Ray\SymfonySessionModule;

use Ray\SymfonySessionModule\Annotation\Sessional;

class FakeSessionalMethodConsumer
{
    use SessionInject;

    /**
     * @Sessional
     */
    public function sessionIsStarted()
    {
        return $this->session->isStarted();
    }

    public function sessionIsNotStarted()
    {
        return !$this->session->isStarted();
    }
}
