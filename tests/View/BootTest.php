<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Tests\Mvc\View;

use Phalcon\Events\Event;
use Phalcon\Mvc\Router\Exception;
use Vegas\Mvc\View\EventListener\Boot;

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
    }

    public function testBootView()
    {
        $this->assertFalse($this->di->has('view'));

        $bootInstance = new Boot();
        $bootInstance->boot(new Event('test', $this,  [], false), $this->app);

        $this->assertTrue($this->di->has('view'));
    }


    public function testBootEmptyView()
    {
        $this->assertFalse($this->di->has('view'));

        $config = $this->config;
        $config->application->view = false;
        $this->app = new \Vegas\Mvc\Application($this->di, $config);

        $bootInstance = new Boot();
        $bootInstance->boot(new Event('test', $this,  [], false), $this->app);

        $this->assertFalse($this->di->has('view'));
    }

}