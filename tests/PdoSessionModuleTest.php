<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\Injector;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class PdoSessionModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function setUp()
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        (new PdoSessionHandler($this->pdo))->createTable();
    }

    /**
     * @runInSeparateProcess
     */
    public function testModule()
    {
        $lifetime = 60 * 60 * 24; // 1 day

        $instance = (new Injector(new PdoSessionModule($this->pdo, ['cookie_lifetime' => $lifetime]), $_ENV['TMP_DIR']))->getInstance(SessionInterface::class);
        /* @var $instance SessionInterface */

        $this->assertInstanceOf(SessionInterface::class, $instance);

        $instance->start();

        $this->assertEquals($lifetime, $instance->getMetadataBag()->getLifetime());
    }
}
