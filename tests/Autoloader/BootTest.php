<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Tests\Mvc\Autoloader;

use Phalcon\DI;
use Phalcon\Events\Event;
use Vegas\Mvc\Autoloader\EventListener\Boot;
use Vegas\Mvc\Router;

class BootTest extends \PHPUnit_Framework_TestCase
{
    protected $app, $di, $config;

    public function setUp()
    {
        parent::setUp();

        $di = new \Phalcon\DI\FactoryDefault();
        $config = new \Phalcon\Config(require APP_ROOT . '/app/config/config.php');

        $application = new \Vegas\Mvc\Application($di, $config);

        $this->app = $application;
        $this->di = $this->app->getDI();
        $this->config = $this->app->getConfig();

        $bootInstance = new \Vegas\Mvc\ModuleManager\EventListener\Boot();
        $bootInstance->boot(new Event('test', $this,  [], false), $this->app);
    }

    public function testBootView()
    {
        $namespaces = (new Boot())->getNamespaces($this->app);
        $appDirectory = APP_ROOT . '/app';

        $this->assertCount(5, $namespaces);

        $this->assertSame([
            'Test' => $appDirectory . '/modules/Test',
            'App\Initializer' => $appDirectory . '/initializers',
            'App\Shared' => $appDirectory . '/shared',
            'App\View' => $appDirectory . '/view',
            'Lib' => APP_ROOT . '/lib',
        ], $namespaces);

    }


}