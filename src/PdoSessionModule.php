<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\SymfonySessionModule\Annotation\SessionOptions;
use Ray\SymfonySessionModule\Annotation\SessionStorage;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PdoSessionModule extends AbstractModule
{
    /**
     * Constructor.
     *
     * @param \PDO $pdo
     * @param array $options
     */
    public function __construct(\PDO $pdo, array $options = [])
    {
        parent::__construct();
        
        $this->bind(\PDO::class)->annotatedWith(SessionStorage::class)->toInstance($pdo);
        $this->bind()->annotatedWith(SessionOptions::class)->toInstance($options);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(SessionInterface::class)->toProvider(PdoSessionProvider::class)->in(Scope::SINGLETON);
    }
}
