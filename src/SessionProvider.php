<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\ProviderInterface;
use Ray\SymfonySessionModule\Annotation\SessionHandler;
use Ray\SymfonySessionModule\Annotation\SessionOptions;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;

class SessionProvider implements ProviderInterface
{
    /**
     * @var AbstractProxy|\SessionHandlerInterface
     */
    private $handler;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor
     *
     * @param AbstractProxy|\SessionHandlerInterface $handler
     * @param array                                  $options
     *
     * @SessionHandler("handler")
     * @SessionOptions("options")
     */
    public function __construct($handler, array $options = [])
    {
        $this->handler = $handler;
        $this->options = $options;
    }

    /**
     * @return SessionInterface
     */
    public function get()
    {
        $storage = new NativeSessionStorage($this->options, $this->handler);

        return new Session($storage);
    }
}
