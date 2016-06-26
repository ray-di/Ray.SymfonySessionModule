<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\SymfonySessionModule\Annotation\SessionHandler;
use Ray\SymfonySessionModule\Annotation\SessionOptions;
use Ray\SymfonySessionModule\Annotation\SessionStorage;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class PdoSessionModule extends AbstractModule
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
     * Constructor.
     *
     * @param \PDO  $pdo
     * @param array $options
     */
    public function __construct(\PDO $pdo, array $options = [])
    {
        $this->pdo = $pdo;
        $this->options = $options;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->bind()->annotatedWith(SessionStorage::class)->toInstance($this->pdo);
        $this->bind()->annotatedWith(SessionHandler::class)->toConstructor(PdoSessionHandler::class, 'pdoOrDsn=' . SessionStorage::class);

        $this->bind()->annotatedWith(SessionOptions::class)->toInstance($this->options);

        $this->bind(SessionInterface::class)->toProvider(SessionProvider::class)->in(Scope::SINGLETON);
    }
}
