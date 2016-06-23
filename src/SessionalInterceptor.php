<?php

namespace Ray\SymfonySessionModule;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\SymfonySessionModule\Exception\SessionExpiredException;

class SessionalInterceptor implements MethodInterceptor
{
    use SessionInject;

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $this->session->start();

        $metadataBag = $this->session->getMetadataBag();
        $lifetime = $metadataBag->getLifetime();

        if ($lifetime > 0 && $metadataBag->getLastUsed() + $lifetime < time()) {
            $this->session->invalidate();
            throw new SessionExpiredException('Session has expired.');
        }

        $this->session->migrate();

        return $invocation->proceed();
    }
}
