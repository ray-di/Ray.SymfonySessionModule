<?php

namespace Ray\SymfonySessionModule;

class FakeConsumer
{
    use SessionInject;

    public function sessionIsStarted()
    {
        return $this->session->isStarted();
    }
}
