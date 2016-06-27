<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\ProviderInterface;
use Ray\SymfonySessionModule\Annotation\SessionOptions;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class SessionProvider implements ProviderInterface
{
    /**
     * @var \SessionHandlerInterface
     */
    private $handler;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor
     *
     * @param \SessionHandlerInterface $handler
     * @param array                    $options
     *
     * @SessionOptions("options")
     */
    public function __construct(\SessionHandlerInterface $handler, array $options = [])
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
