<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\Di\Inject;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

trait SessionInject
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @param SessionInterface $session
     *
     * @Inject
     */
    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }
}
