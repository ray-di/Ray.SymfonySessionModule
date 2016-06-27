<?php

namespace Ray\SymfonySessionModule;

use Ray\Di\Injector;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class PdoSessionModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testModule()
    {
        $pdo = new \PDO('sqlite::memory:');
        $lifetime = 60 * 60 * 24; // 1 day

        $module = new PdoSessionModule($pdo, ['cookie_lifetime' => $lifetime]);
        $injector = new Injector($module, $_ENV['TMP_DIR']);

        $session = $injector->getInstance(SessionInterface::class);
        $handler = $injector->getInstance(\SessionHandlerInterface::class);

        $this->assertInstanceOf(SessionInterface::class, $session);
        /* @var $session SessionInterface */

        $this->assertInstanceOf(PdoSessionHandler::class, $handler);
        /* @var $handler PdoSessionHandler */

        $handler->createTable();

        $session->start();

        $this->assertEquals($lifetime, ini_get('session.cookie_lifetime'));
        $this->assertEquals($lifetime, $session->getMetadataBag()->getLifetime());
    }
}
