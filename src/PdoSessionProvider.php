<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\ProviderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class PdoSessionProvider implements ProviderInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor
     *
     * @param \PDO $pdo
     * @param array $options
     */
    public function __construct(\PDO $pdo, array $options = [])
    {
        $this->pdo = $pdo;
        $this->options = $options;
    }

    /**
     * @return SessionInterface
     */
    public function get()
    {
        $handler = new PdoSessionHandler($this->pdo);
        $storage = new NativeSessionStorage($this->options, $handler);
        return new Session($storage);
    }
}
